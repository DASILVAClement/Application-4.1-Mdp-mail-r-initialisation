<?php

require_once __DIR__ . "/../src/fonctions/calculComplexiteMdp.php";

use PHPUnit\Framework\TestCase;

class calculComplexiteMdpTest extends TestCase {

public function testMotDePasseSimpleMinuscules() {
$this->assertEquals(24, CalculComplexiteMdp("aubry"));
}

public function testMotDePasseMinusculesAvecSymbole() {
$this->assertEquals(59, CalculComplexiteMdp("super@ubry"));
}

public function testMotDePasseComplexeAvecMajusculesChiffresSymboles() {
$this->assertEquals(92, CalculComplexiteMdp("Super@ubry2022"));
}

public function testMotDePasseTresComplexe() {
$this->assertEquals(151, CalculComplexiteMdp("Giroud-Président||2027"));
}

public function testMotDePasseVide() {
$this->assertEquals(0, CalculComplexiteMdp(""));
}
}