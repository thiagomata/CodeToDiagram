<?php
class History
{
    public function __construct()
    {
        $objPig1 = new LittlePig();
        $objPig2 = new LittlePig();
        $objPig3 = new LittlePig();

        $objPig1->buildHouse('Straw');
        $objPig2->buildHouse('Stick');
        $objPig3->buildHouse('Brick');

        $objWolf = new Wolf();
        $objWolf->blowIt( $objPig1->getHouse() );
        $objWolf->blowIt( $objPig2->getHouse() );
        $objWolf->blowIt( $objPig3->getHouse() );
    }
}
?>
