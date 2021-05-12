<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
  /**
   * @dataProvider geraLances
   */
  public function testLeilaoDeveReceberLances(int $qtdeLances, Leilao $leilao, array $valores)
  {
    static::assertCount($qtdeLances, $leilao->getLances());
    foreach($valores as $i => $valorEsperado) {
      static::assertEquals($valorEsperado, $leilao->getLances()[$i]->getValor());
    }
  }

  public function testeLeilaoNaoDeveReceberLancesRepetidosDeMesmoUsuario()
  {
    $leilao = new Leilao('Variante');
    $ana = new Usuario('Ana');

    $leilao->recebeLance(new Lance($ana, 1000));
    $leilao->recebeLance(new Lance($ana, 2000));

    static::assertCount(1, $leilao->getLances());
    static::assertEquals(1000, $leilao->getLances()[0]->getValor());
  }

  public function geraLances()
  {
    $joao = new Usuario('João');
    $maria = new Usuario('Maria');

    $leilaoCom2Lance = new Leilao('Fiat 147 0km');
    $leilaoCom2Lance->recebeLance(new Lance($joao, 1000));
    $leilaoCom2Lance->recebeLance(new Lance($maria, 2000));

    $leilaoCom1Lance = new Leilao('Fusca 1972 0km');
    $leilaoCom1Lance->recebeLance(new Lance($maria, 3000));

    return [
      '2-lances' => [2, $leilaoCom2Lance, [1000, 2000]],
      '1-lance' => [1, $leilaoCom1Lance, [3000]]
    ];
  }
}