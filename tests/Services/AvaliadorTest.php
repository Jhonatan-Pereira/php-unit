<?php

namespace Alura\Leilao\Tests\Service;

use PHPUnit\Framework\TestCase;
use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Services\Avaliador;

require 'vendor/autoload.php';

class AvaliadorTest extends TestCase
{
  public function testAvaliadorDeveEncontrarOMaiorValorDeLanceEmOrdemCrescente() {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $joao = new Usuario('Joao');

    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($maria, 2500));

    $leiloreiro = new Avaliador();
    $leiloreiro->avalia($leilao);

    $maiorValor = $leiloreiro->getMaiorValor();

    self::assertEquals(2500, $maiorValor);
  }

  public function testAvaliadorDeveEncontrarOMaiorValorDeLanceEmOrdemDescrescente() {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $joao = new Usuario('Joao');

    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($joao, 2000));

    $leiloreiro = new Avaliador();
    $leiloreiro->avalia($leilao);

    $maiorValor = $leiloreiro->getMaiorValor();

    self::assertEquals(2500, $maiorValor);
  }

  public function testAvaliadorDeveEncontrarOMenorValorDeLanceEmOrdemDescrescente() {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $joao = new Usuario('Joao');

    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($joao, 2000));

    $leiloreiro = new Avaliador();
    $leiloreiro->avalia($leilao);

    $menorValor = $leiloreiro->getMenorValor();

    self::assertEquals(2000, $menorValor);
  }

  public function testAvaliadorDeveEncontrarOMenorValorDeLanceEmOrdemCrescente() {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $joao = new Usuario('Joao');

    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($maria, 2500));

    $leiloreiro = new Avaliador();
    $leiloreiro->avalia($leilao);

    $menorValor = $leiloreiro->getMenorValor();

    self::assertEquals(2000, $menorValor);
  }
}