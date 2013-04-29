<?php

namespace Pheasant\Tests\Relationships;

use \Pheasant\Tests\Examples\Hero;
use \Pheasant\Tests\Examples\Power;
use \Pheasant\Tests\Examples\SecretIdentity;

class JoinTestCase extends \Pheasant\Tests\MysqlTestCase
{
    public function setUp()
    {
        parent::setUp();

        $migrator = new \Pheasant\Migrate\Migrator();
        $migrator
            ->create('hero', Hero::schema())
            ->create('power', Power::schema())
            ->create('secretidentity', SecretIdentity::schema())
            ;

        $hero = Hero::create(array('alias'=>'Spider Man'));
        $power = Power::create(array('description'=>'Spider Senses', 'Hero'=>$hero));
    }

    public function testSimpleJoin()
    {
        $heros = Hero::find()->join('Powers');

        $this->assertEquals('Spider Man', $heros[0]->alias);
        $this->assertEquals('Spider Senses', $heros[0]->Powers[0]->description);
    }
}


