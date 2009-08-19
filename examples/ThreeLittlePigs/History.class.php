<?php
/**
 * History of the Three Little Pigs Example
 * @package examples
 * @subpackage ThreeLittlePigs
 */

/**
 *
 * Class with the history of the three little pigs
 * 
 * @author Thiago Henrique Ramos da Mata <thiago.henrique.mata@gmail.com>
 * 
 * 1. create the first pig
 * 2. create the second pig
 * 3. create the third pig
 * 4. the first pig build a straw house
 * 5. the second pig build a stick house
 * 6. the third pig build a brick housve
 * 7. create the wolf
 * 8. the wolf blow the house of the first pig
 * 9. the wolf blow the house of the second pig
 * 10. the wolf blow the house of the third pig
 */
class History
{
    public function __construct()
    {
        CodeToDiagram::getInstance()->addNote( "Once upon a time" );

        CodeToDiagram::getInstance()->addNote( "Three Little Pigs who lives into a beautiful Wood" );

        $objPig1 = new LittlePig();
        $objPig2 = new LittlePig();
        $objPig3 = new LittlePig();

        $objPig1->buildHouse('Straw');
        $objPig2->buildHouse('Stick');
        $objPig3->buildHouse('Brick');


        CodeToDiagram::getInstance()->addNote( "One night the big bad wolf," );
        $objWolf = new Wolf();

        $objWolf->say( "Let me in, Let me in, little pig or I'll huff and I'll puff and I'll blow your house in!" );
        $objWolf->blowIt( $objPig1->getHouse() );
        $objWolf->blowIt( $objPig2->getHouse() );
        $objWolf->blowIt( $objPig3->getHouse() );
    }
}
?>
