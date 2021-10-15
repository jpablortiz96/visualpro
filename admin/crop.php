<?php
	session_start();
    include "../conexion.php";

    $folder = 'imagenes/';
    $filename = $_GET['filename'];
    $orig_w = 480;
    $orig_h = $_GET['height'];
    $tamano = $_GET['size'];
    $user = $_SESSION['idUser'];

    if ($tamano == '3x4' ) {
        $targ_w = 104;
        $targ_h = 139;
    }elseif ($tamano == '3x3') {
        $targ_w = 139;
        $targ_h = 139;
    }else{
        $targ_w = 104;
        $targ_h = 139;
    }
    $ratio = $targ_w/$targ_h;

    if (isset($_POST['submit'])) {

        $src = imagecreatefromjpeg($folder.$filename);

        $tmp = imagecreatetruecolor(4.6*$targ_w, 4.6*$targ_h);
        imagecopyresampled($tmp, $src, 0, 0, $_POST['x'], $_POST['y'], 4.6*$targ_w, 4.6*$targ_h, $_POST['w'], $_POST['h']);

        imagejpeg($tmp, $folder.$filename ,100);

        $sql="UPDATE `administrador` SET `foto` = '$folder.$filename' WHERE `administrador`.`id` = '$user'";
        $res=mysqli_query($conection,$sql);

        if($res){
              echo '<script type="text/javascript"> alert("Cargue de Foto Correctamente"); window.location="inicio_foto.php";</script>';

        }else{
              die("Error".mysqli_error($conection));
        } 

        imagedestroy($tmp);
        imagedestroy($src);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minium-scale=1.0">
	<?php include "includes/scripts.php" ?>
	<title>VISUALPRO</title>
</head>
<body>
	<?php include "includes/header.php" ?>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.Jcrop.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.Jcrop.css"/>
    <script type="text/javascript">
        $(function(){
            $('#cropbox').Jcrop({
                aspectRatio: <?php echo $ratio?>,
                setSelect: [0,0,<?php echo $orig_w.','.$orig_h;?>],
                onSelect: updateCoords,
                onChange: updateCoords
                });
        });

        function updateCoords(c){
            showPreview(c);
            $("#x").val(c.x);
            $("#y").val(c.y);
            $("#w").val(c.w);
            $("#h").val(c.h);
        }

        function showPreview(coords){
            var rx = <?php echo $targ_w;?> / coords.w;
            var ry = <?php echo $targ_h;?> / coords.h;

            $("#preview img").css({
                width: Math.round(rx*<?php echo $orig_w;?>)+'px',
                height: Math.round(ry*<?php echo $orig_h;?>)+'px',
                marginLeft: '-'+ Math.round(rx*coords.x)+'px',
                marginTop: '-'+ Math.round(ry*coords.y)+'px',
            });
        }
    </script>
    <style type="text/css">
        #preview{
            width: <?php echo $targ_w?>px;
            height: <?php echo $targ_h?>px;
            overflow: hidden;          
        }
    </style>

	<div class="container-all" id="container">
  
            <h1>Ajuste de Foto</h1>
            <table>
                <tr id="tabla_ajuste">
                    <td align="center">
                        <img src="<?php echo $folder.$filename?>" id="cropbox" alt="cropbox" content="width=device-width, user-scalable=no, initial-scale=1.0, maximun-scale=1.0, minium-scale=1.0"/>
                    </td>
                    <td id="fondo" align="center">
                        <h3>Previsualización:</h3>
                        <div id="preview">
                            <img src="<?php echo $folder.$filename?>" alt="thumb"/>
                        </div>
                        <!---<h3 id="title_formato">Formato de foto:<h3>--->
                        <form action="<?php echo $_SERVER['REQUEST_URI']?>" method="post" width="100" id="form_enviar_foto">
                            <p>
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                                <input type="submit" id="submit" name="submit" value="Enviar foto" />
                            </p>
                        </form>
                    </td>
                </tr>
            </table>
    </div>

	<script src="js/menu.js"></script>
    <?php include "includes/footer.php" ?>
</body>
</html>