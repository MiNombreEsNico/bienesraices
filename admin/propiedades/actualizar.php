<?php
 
use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;
 
 
require '../../includes/app.php';
 
    estaAutenticado();
 
    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    if(!$id) {
        header('location: /admin');
    }
 
 
    // Obtener los Datos de la propiedad
    $propiedad = Propiedad::find($id);
 
 
    // Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);
 
    // Arreglo con mensajes de errores
    $errores = Propiedad::getErrores();
    
 
 
    // Ejecutar el código después de que el usuario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
 
        // Asignar los atributos
        $args = $_POST['propiedad'];
        $propiedad->sync($args);
 
        // Validación 
        $errores = $propiedad->validar();     
 
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Asignar los atributos
            $args = $_POST['propiedad'];
            $propiedad->sync($args);
     
            $errores = $propiedad->validar();
            
            //Revisar que el arreglo de errores esté vacío
            if (empty($errores)) {
                
                if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    
                    //Generar un nombre único
                    $nombreImagen = md5( uniqid( rand(), true) ) . ".jpg";
     
                    //Realiza un resize a la imagen con intervention
                    $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
     
                    /*Setear la imagen*/
                    $propiedad->setImagen($nombreImagen);
     
                    //Guarda la imagen en el servidor
                    $image->save(CARPETA_IMAGENES . $nombreImagen);

                    // Redirecciona al usuario.
                header('location: /admin?resultado=2');
                }
                // Redirecciona al usuario.
                header('location: /admin?resultado=2');
            }   
        }
        $resultado = $propiedad->guardar();
    }
 
    incluirTemplate("header"); 
?>
 
    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
 
        <a href="/admin" class="boton boton-verde">Volver</a>
 
        <?php foreach($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>    
               
        <?php endforeach; ?>
 
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>
 
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
 
        </form>
 
    </main>
 
<?php incluirTemplate('footer'); ?>