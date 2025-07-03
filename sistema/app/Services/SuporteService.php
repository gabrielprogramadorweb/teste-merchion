<?php
    namespace App\Services;

    use Illuminate\Support\Facades\Http;
    use Illuminate\Support\Facades\Log;

    class SuporteService
    {
        public function responderMensagem(string $mensagem): string
        {
            if (preg_match('/^(oi+|ol[áa]+|bom dia+|boa tarde+|boa noite+|e[ai]+|tem alguém[ aí]*\??)$/i', $mensagem)) {
                return 'Olá! 👋 Sou agente IA do FlowTask, Como posso te ajudar? Me envie sua dúvida e te explico com prazer. 😊';
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
                $apiKey = env('GROQ_API_KEY');

                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ])->post('https://api.groq.com/openai/v1/chat/completions', $payload);

                #dd(env('GROQ_API_KEY'));

                if ($response->successful()) {
                    $json = $response->json();
                    return nl2br($json['choices'][0]['message']['content'] ?? 'Desculpe, não consegui gerar uma resposta agora.');
                }

                Log::error('Falha na resposta da IA: ' . $response->body());
                return 'Desculpe, não consegui gerar uma resposta agora.';
            } catch (\Throwable $e) {
                Log::error('Erro no SuporteService: ' . $e->getMessage());
                return 'Desculpe, ocorreu um erro ao tentar responder. Tente novamente mais tarde.';
            }
        }
    }
