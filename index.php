<?php

use Util\ConstantesGenericasUtil;
use Util\JsonUtil;
use Util\RotasUtil;
use Validator\RequestValidator;

include 'bootstrap.php';

try {
    $RequestValidator = new RequestValidator(RotasUtil::getRotas());
    $retorno = $RequestValidator->processarRequest();

    $jsonUtil = new JsonUtil();
    $jsonUtil->processarArrayParaRetornar($retorno);
    
} catch (\Exception $e) {
    die( json_encode([
        ConstantesGenericasUtil::TIPO => ConstantesGenericasUtil::TIPO_ERRO,
        ConstantesGenericasUtil::RESPOSTA => $e->getMessage()
    ]));
}
