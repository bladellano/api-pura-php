<?php

namespace Service;

use InvalidArgumentException;
use Repository\UsuariosRepository;
use Util\ConstantesGenericasUtil;

class UsuariosService
{

    public const TABELA = 'usuarios';
    public const RECURSOS_GET = ['listar'];
    public const RECURSOS_DELETE = ['deletar'];

    private array $dados;

    private object $usuariosRepository;

    public function __construct($dados = [])
    {
        $this->dados = $dados;
        $this->usuariosRepository = new UsuariosRepository();
    }

    public function validarGet()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_GET, true)) {
            $retorno = $this->dados['id'] > 0 ? $this->getOneByKey() : $this->$recurso(); //*Função variável
        } else {
            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if ($retorno === null) {
            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        return $retorno;
    }

    public function validarDelete()
    {
        $retorno = null;
        $recurso = $this->dados['recurso'];

        if (in_array($recurso, self::RECURSOS_DELETE, true)) {

            if ($this->dados['id'] > 0) {
                $retorno = $this->$recurso();
            } else {
                throw new InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_ID_OBRIGATORIO);
            }
        } else {
            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_RECURSO_INEXISTENTE);
        }

        if ($retorno === null) {
            throw new \InvalidArgumentException(ConstantesGenericasUtil::MSG_ERRO_GENERICO);
        }
        return $retorno;
    }

    private function getOneByKey()
    {
        return $this->usuariosRepository->getMySQL()->getOneByKey(self::TABELA, $this->dados['id']);
    }

    public function listar()
    {
        return $this->usuariosRepository->getMySQL()->getAll(self::TABELA);
    }

    public function deletar()
    {
        return $this->usuariosRepository->getMySQL()->delete(self::TABELA,$this->dados['id']);
    }
}
