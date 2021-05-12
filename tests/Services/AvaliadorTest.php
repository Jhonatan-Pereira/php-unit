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
  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao) 
  {
    $leiloreiro = new Avaliador();
    $leiloreiro->avalia($leilao);

    $maiorValor = $leiloreiro->getMaiorValor();

    self::assertEquals(2500, $maiorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao) 
  {
    $leiloreiro = new Avaliador();
    $leiloreiro->avalia($leilao);

    $menorValor = $leiloreiro->getMenorValor();

    self::assertEquals(1000, $menorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvalidadorDeveBuscar3MaioresValores(Leilao $leilao)
  {
    $leiloreiro = new Avaliador();
    $leiloreiro->avalia($leilao);

    $maioresLances = $leiloreiro->getMaioresLances();
    static::assertCount(3, $maioresLances);
    static::assertEquals(2500, $maioresLances[0]->getValor());
    static::assertEquals(2000, $maioresLances[1]->getValor());
    static::assertEquals(1500, $maioresLances[2]->getValor());
  }

  public function leilaoEmOrdemCrescente(): array
  {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $jorge = new Usuario('Jorge');
    $joao = new Usuario('Joao');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($jorge, 1500));
    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($ana, 1000));

    return [
      [$leilao]
    ];
  }

  public function leilaoEmOrdemDecrescente(): array
  {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $jorge = new Usuario('Jorge');
    $joao = new Usuario('Joao');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($jorge, 1500));
    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($ana, 1000));

    return [
      [$leilao]
    ];
  }

  public function leilaoEmOrdemAleatoria(): array
  {
    $leilao = new Leilao('Fiat 147 0km');

    $maria = new Usuario('Maria');
    $jorge = new Usuario('Jorge');
    $joao = new Usuario('Joao');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($joao, 2000));
    $leilao->recebeLance(new Lance($jorge, 1500));
    $leilao->recebeLance(new Lance($maria, 2500));
    $leilao->recebeLance(new Lance($ana, 1000));

    return [
      [$leilao]
    ];
  }
}