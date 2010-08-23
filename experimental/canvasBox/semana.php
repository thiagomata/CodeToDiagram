    <?php
ini_set( "display_errors", "On" );
error_reporting( E_ALL | E_STRICT );
class DatabaseConnection
{
    /**
     * Singleton instance
     * @var DatabaseConnection
     */
    protected static $objInstance;

    /**
     * Connection
     * @var DatabaseConnection
     */
    protected $objConnection;

    /**
     *
     * @return DatabaseConnection
     */
    public static function getInstance()
    {
        if( self::$objInstance == null )
        {
            self::$objInstance = new DatabaseConnection();
        }
        return self::$objInstance;
    }

    public function __construct()
    {
        $this->objConnection = new PDO(
            'mysql:host=127.0.0.1;dbname=semana-de-extensao;charset=UTF-8',
            'root',
            '123456'
        );
        $this->objConnection->beginTransaction();
    }

    public function __destruct()
    {
        $this->objConnection->commit();
    }

    /**
     *
     * @param string $strSql
     * @return boolean|array
     */
    public function run( $strSql , $arrParams = array() )
    {
        $objPrepare = $this->objConnection->prepare( $strSql );
        $objPrepare->execute( $arrParams );
        $arrResult = $objPrepare->fetchAll();
        return $arrResult;
    }
}

class DrawFlow
{
    protected $arrStates;
    protected $arrLines;

    public function getStates()
    {
        if( $this->arrStates == null )
        {
            $strSql = "select * from tb_situacao_atividade order by id_situacao_atividade  ";
            $this->arrStates = DatabaseConnection::getInstance()->run( $strSql );
        }
        return $this->arrStates;
    }


    public function getLines()
    {
        if( $this->arrLines == null )
        {
            $strSql = "select * from tb_acao_em_atividade order by id_acao_em_atividade ";
            $this->arrLines = DatabaseConnection::getInstance()->run( $strSql );
        }
        return $this->arrLines;
    }

}

$objDrawFlow = new DrawFlow();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="../phpjs/php.js" ></script>
    <script type="text/javascript" src="./autoLoad/jsAutoLoad.js.php?deep=0"  ></script>
    <script type="text/javascript" >
        window.autoload.loadPrototype();
    </script>
        <style>
            *
            {
                padding: 0;
                margin: 0;
                border: none;
            }
            canvas
            {
                border-style: solid;
                border-color: black;
                border-width: 1px;
            }
            #abc
            {
                margin-left:0px;
                margin-top:0px;
            }
      </style>
  </head>
  <body>
      <div>
        <canvas id="abc">
        </canvas>
      </div>
    <script type="text/javascript" charset="utf-8">
        var objBox = new autoload.newCanvasBoxStateDiagram( "abc" , document.body.clientWidth - 10, document.body.clientHeight - 10  );
        window.box = objBox;
            window.box.dblZoom = 0.3;
       window.box.width  = window.box.defaultWidth  / window.box.dblZoom;
       window.box.height = window.box.defaultHeight / window.box.dblZoom;
        function addStateElement( strStateName , color )
        {
            var objStateElement = new autoload.newCanvasBoxState();
            objStateElement.objBehavior = new autoload.newCanvasBoxMagneticBehavior( objStateElement );
//            objStateElement.objBehavior = new autoload.newCanvasBoxDefaultBehavior( objStateElement );
            objStateElement.x = rand( window.box.width  );
            objStateElement.y = rand( window.box.height  );
            objStateElement.strStateName = strStateName;
            objStateElement.drawFixed( false );
            if( color )
            {
                objStateElement.fillColor = color;
                objStateElement.fixedColor = color;
                objStateElement.defaultColor = color;
            }
            else
            {
                objStateElement.fillColor = "orange";
                objStateElement.fixedColor = "#66AAff";
            }
            window.box.addElement( objStateElement );
            return objStateElement;
        }

        function addEvent( objFrom , objTo , strName  )
        {
            strName = str_replace( " " , "\n" , strName );
            var objEvent = addStateElement( strName , "#DDFFDD" );
           addLine( objFrom , objEvent );
           addLine( objEvent , objTo );

        }

        function addLine( objFrom , objTo , strName , color )
        {
            if( objFrom == undefined || objTo == undefined )
            {
                return;
            }

            var objLine = new autoload.newCanvasBoxStateLink( objFrom , objTo  );
            objLine.strName = strName;
//             objLine.objBehavior = new autoload.newCanvasBoxMagneticConnectorBehavior( objLine );
             objLine.objBehavior = new autoload.newCanvasBoxElasticConnectorBehavior( objLine );
//           objLine.objBehavior = new autoload.newCanvasBoxDefaultConnectorBehavior( objLine );
            objLine.x =  ( objFrom.x + objTo.x  ) / 2;
            objLine.y =  ( objFrom.y + objTo.y  ) / 2;
            if( color )
            {
                objLine.color = color;
            }
            window.box.addElement( objLine );
            return objLine;
        }
        var arrStates = new Object();
        <?php foreach(  $objDrawFlow->getStates() as $intPos => $objState ): ?>
            var objState = addStateElement("<?php print utf8_encode( $objState['txt_nome_situacao_atividade'] ) ?>");
            arrStates[ <?php print $objState[ 'id_situacao_atividade'] ?> ] = objState;
        <?php endforeach ?>
        <?php foreach(  $objDrawFlow->getLines() as $intPos => $objLine): ?>
             addEvent(
                arrStates[ <?php print (integer)$objLine[ 'id_situacao_atividade_antes' ] ?> ] ,
                arrStates[ <?php print (integer)$objLine[ 'id_situacao_atividade_depois' ] ?> ] ,
                '<?php print utf8_encode( $objLine[ 'txt_nome_acao_em_atividade' ] ) ?>'
            ); 
            
        <?php endforeach ?>
    </script>
  </body>
</html>
