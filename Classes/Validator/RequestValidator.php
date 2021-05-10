<?php

namespace Validator;

use InvalidArgumentException;
use Repository\TokensAutorizadosRepository;
use Service\UsuariosService;
use Util\ConstantesGenericasUtil;
use Util\JsonUtil;

class RequestValidator
{

    private array $request;
    private array $dadosRequest;
    private object $tokensAutorizadosRepository;

    const GET = 'GET';
    const DELETE = 'DELETE';
    const USUARIOS = 'USUARIOS';
    //REFATORAR
    public function __construct($request)
    {
        $this->request = $request;
        $this->tokensAutorizadosRepository = new TokensAutorizadosRepository();
    }

    public function processarRequest()
    {
        $retorno = utf8_encode(ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA);

        if (in_array($this->request['metodo'], ConstantesGenericasUtil::TIPO_REQUEST, true)) {
            $retorno = $this->direcionarRequest();
        }
        //!echo '<pre>$retorno<br />'; var_dump($retorno); echo '</pre>';
        return $retorno;
    }
    private function direcionarRequest()
    {
        if ($this->request['metodo'] !== self::GET && $this->request['metodo'] !== self::DELETE) {
            $this->dadosRequest = JsonUtil::tratarCorpoRequisicaoJson();
        }
        $this->tokensAutorizadosRepository->validarToken(getallheaders()['Authorization']);
        $metodo = $this->request['metodo'];
        return $this->$metodo(); //!Método variável
    }

    private function get()
    {
        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_GET, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS;
                    $usuariosService = new UsuariosService($this->request);
                    $retorno = $usuariosService->validarGet();
                    break;

                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        
        return $retorno;
    }


    private function delete()
    {

        $retorno = ConstantesGenericasUtil::MSG_ERRO_TIPO_ROTA;
        if (in_array($this->request['rota'], ConstantesGenericasUtil::TIPO_DELETE, true)) {
            switch ($this->request['rota']) {
                case self::USUARIOS;
                    $usuariosService = new UsuariosService($this->request);
                    $retorno = $usuariosService->validarDelete();
                    break;

                default:
                    throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
            }
        }
        
        return $retorno;
    }
}
