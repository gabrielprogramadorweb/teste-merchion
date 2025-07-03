<?php
    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Http\Requests\SuporteRequest;
    use App\Services\SuporteService;
    use Illuminate\Http\JsonResponse;
    use Illuminate\Support\Facades\Log;

    class SuporteController extends Controller
    {
        public function __construct(protected SuporteService $service) {}

        public function responder(SuporteRequest $request): JsonResponse
        {
            try {
                $mensagem = trim($request->input('mensagem'));

                $resposta = $this->service->responderMensagem($mensagem);

                return response()->json([
                    'resposta' => $resposta,
                    'pergunta' => $mensagem,
                    'respondido_em' => now()->format('d/m/Y H:i'),
                ]);
            } catch (\Throwable $e) {
                Log::error('Erro no suporte IA: ' . $e->getMessage());

                return response()->json([
                    'erro' => 'Ocorreu um erro ao tentar responder sua pergunta.'
                ], 500);
            }
        }
    }
