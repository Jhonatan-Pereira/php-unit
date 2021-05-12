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

  private $leiloreiro = null;
  protected function setUp(): void
  {
    $this->leiloreiro = new Avaliador();
  }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveEncontrarOMaiorValorDeLances(Leilao $leilao) 
  {
    $this->leiloreiro->avalia($leilao);

    $maiorValor = $this->leiloreiro->getMaiorValor();

    self::assertEquals(2500, $maiorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvaliadorDeveEncontrarOMenorValorDeLances(Leilao $leilao) 
  {
    $this->leiloreiro->avalia($leilao);

    $menorValor = $this->leiloreiro->getMenorValor();

    self::assertEquals(1000, $menorValor);
  }

  /**
   * @dataProvider leilaoEmOrdemAleatoria
   * @dataProvider leilaoEmOrdemDecrescente
   * @dataProvider leilaoEmOrdemAleatoria
   */
  public function testAvalidadorDeveBuscar3MaioresValores(Leilao $leilao)
  {
    $this->leiloreiro->avalia($leilao);

    $maioresLances = $this->leiloreiro->getMaioresLances();
    static::assertCount(3, $maioresLances);
    static::assertEquals(2500, $maioresLances[0]->getValor());
    static::assertEquals(2000, $maioresLances[1]->getValor());
    static::assertEquals(1500, $maioresLances[2]->getValor());
  }

  public function testLeilaoVazioNaoPodeSerAvaliado()
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Não é possível avaliar leilão vazio');
    $leilao = new Leilao('Fiat 147 0km');
    $this->leiloreiro->avalia($leilao);
  }

  public function testLeilaoFinalizadoNaoPodeSerAvaliado()
  {
    $this->expectException(\DomainException::class);
    $this->expectExceptionMessage('Leilão já finalizado');

    $leilao = new Leilao('Fiat 147 0km');
    $leilao->recebeLance(new Lance(new Usuario('João'), 1000));
    $leilao->finaliza();

    $this->leiloreiro->avalia($leilao);
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
      'ordem-crescente'=>[$leilao]
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
      'ordem-decrescente'=>[$leilao]
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
      'ordem-aleatoria'=>[$leilao]
    ];
  }
}