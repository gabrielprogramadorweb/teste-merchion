<?php
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Log;

    class SuporteController extends Controller
    {
        public function responder(Request $request)
        {
            $request->validate([
                'mensagem' => 'required|string',
            ]);

            $mensagem = trim($request->input('mensagem'));

            if (preg_match('/^(oi+|ol[áa]+|bom dia+|boa tarde+|boa noite+|e[ai]+|tem alguém[ aí]*\??)$/i', $mensagem)) {
                return response()->json([
                    'resposta' => 'Olá! 👋 Sou agente IA do FlowTask, Como posso te ajudar? Me envie sua dúvida e te explico com prazer. 😊',
                    'pergunta' => $mensagem,
                    'respondido_em' => now()->format('d/m/Y H:i'),
                ]);
            }

            try {
                $promptBase = <<<EOT
                Você é o assistente virtual oficial do sistema FlowTask 🧠.

                ✨ Seu objetivo:
                - Ser simpático e direto.
                - Usar <b>parágrafos separados</b> para facilitar a leitura.
                - Usar <b>emojis com contexto</b>, como 📝 para edição, 🚀 para tarefas concluídas, 💬 para comentários.
                - Formatar com <b>negrito</b> trechos importantes (use <b> e não **).
                - Se a pergunta for genérica, como "oi", "tem alguém aí?", "como funciona?", responda com acolhimento, explique brevemente o sistema e convide para perguntar algo.

                💡 Sobre o FlowTask:
                - É um sistema de tarefas com 3 colunas: <b>Pendente</b>, <b>Em Progresso</b> e <b>Completo</b>.
                - O botão <b>"Criar"</b> adiciona uma nova tarefa.
                - Tarefas têm nome, descrição, comentários e status.
                - Elas podem ser <b>editadas</b> (ícone ✏️), <b>apagadas</b> (ícone 🗑️) ou <b>comentadas</b> 💬.
                - As ações são salvas automaticamente.

                🛠 Ao explicar algo (ex: como <b>editar uma tarefa</b>), use passo a passo:

                1. Clique no ícone ✏️ da tarefa que deseja editar.

                2. Será exibido um modal com os campos <b>Título</b>, <b>Descrição</b> e <b>Status</b>.

                3. Altere os campos conforme necessário:
                - 📝 Atualize o <b>título</b> da tarefa.
                - 💬 Modifique a <b>descrição</b> com mais detalhes.
                - 🔁 Escolha o <b>Status</b> correto: Pendente, Em Progresso ou Completo.

                4. Clique no botão <b>Atualizar</b> para salvar suas alterações.

                5. Pronto! A tarefa será atualizada com as novas informações 🚀.

                Agora responda a pergunta abaixo de forma amigável, útil e formatada:
                EOT;


                $payload = [
                    'model' => 'meta-llama/llama-4-scout-17b-16e-instruct',
                    'messages' => [
                        ['role' => 'system', 'content' => $promptBase],
                        ['role' => 'user', 'content' => $mensagem],
                    ]
                ];

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . env('GROQ_API_KEY'),
                    'Content-Type' => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', $payload);

                if ($response->successful()) {
                    $json = $response->json();
                    $resposta = $json['choices'][0]['message']['content'] ?? null;
                    $resposta = nl2br($resposta);
                    return response()->json([
                        'resposta' => $resposta ?? 'Desculpe, não consegui gerar uma resposta agora.',
                        'pergunta' => $mensagem,
                        'respondido_em' => now()->format('d/m/Y H:i'),
                    ]);
                } else {
                    return response()->json([
                        'resposta' => 'Desculpe, não consegui gerar uma resposta agora.',
                        'pergunta' => $mensagem,
                        'respondido_em' => now()->format('d/m/Y H:i'),
                    ], 500);
                }
            } catch (\Throwable $e) {
                return response()->json([
                    'erro' => 'Ocorreu um erro ao tentar responder sua pergunta.'
                ], 500);
            }
        }
    }
