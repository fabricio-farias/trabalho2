<?php
/**
 * Created by PhpStorm.
 * User: fabricio.fs
 * Date: 14/11/2018
 * Time: 10:31
 */

define('DS', DIRECTORY_SEPARATOR);
//$parts = explode(DIRECTORY_SEPARATOR, PATH_BASE);
//define('PATH_ROOT',			implode(DIRECTORY_SEPARATOR, $parts));
define('PATH_BASE', dirname(__FILE__));


class Trabalho2App {
    public $_file = array();
    public $_name = '';
    public $_type = '';
    public $_created = '';
    public $_modified = '';
    public $_accessed = '';
    public $_size = '';
    public $_author = '';

    function __construct($file) {

        if(array_key_exists('myFile', $file)){
            $this->checkFile($file);

        }
    }

    function checkFile($file){

        if(file_exists($file['myFile']['name'])){

            $stat = stat($this->_name);

            $this->_file = $file['myFile'];
            $this->_name = $file['myFile']['name'];
            $this->_type = $file['myFile']['type'];
            $this->_created = @date('Y M D H:i:s',filectime($this->_name));
            $this->_modified = @date('Y M D H:i:s',filemtime($this->_name));
            $this->_accessed = @date('Y M D H:i:s',fileatime($this->_name));
            $this->_size = filesize($file['myFile']['name']);
            $this->_author = (function_exists('posix_getpwuid')) ? @posix_getpwuid($stat['uid']) : '';
        }
    }

    function logFile(){
        $text = array();
        $text[] = "[Name] -------> $this->_name \n";
        $text[] = "[Type] -------> $this->_type \n";
        $text[] = "[Size] -------> $this->_size \n";
        $text[] = "[Created] ----> $this->_created \n";
        $text[] = "[Modified] ---> $this->_modified \n";
        $text[] = "[Accessed] ---> $this->_accessed \n";
        $text[] = "[Author] -----> $this->_author \n";

        $f = fopen(PATH_BASE.DS.$this->_name, "w");
        fwrite($f, implode('', $text));
        fclose($f);
    }

    function getInputs(){
        return get_object_vars($this);
    }



}

$app = new Trabalho2App(filter_var_array($_FILES));
$post = $app->getInputs();

if($p = filter_var_array($_POST)){

    $app->_name = $p['name'];
    $app->_type = $p['type'];
    $app->_created = $p['created'];
    $app->_modified = $p['modified'];
    $app->_accessed = $p['accessed'];
    $app->_size = $p['size'];
    $app->_author = $p['author'];

    $app->logFile();
}

?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Trabalho 2</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    </head>
    <body>

      <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="../../assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
            <h2>Trabalho 2</h2>
            <p class="lead">
                Faça um programa que receba 7 atributos de um arquivo e salve em um arquivo.txt <br />
                O programa deve conter:
                <ul>
                <li>Consultar</li>
                <li>Alterar</li>
                <li>Deletar</li>
                <li>Acrescentar</li>
                </ul>
            </p>
        </div>

        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Arquivo</h4>
                <form class="needs-validation" novalidate="" method="post" enctype="multipart/form-data">

                    <?php if(empty($_FILES)):?>
                        <div class="mb-3">
                            <label for="name"></label>
                            <input type="file" name="myFile" id="myFile" class="">
                            <div class="invalid-feedback">
                                Valid file is required.
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if(!empty($_FILES)):?>
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="" value="<?php echo $post['_name'];?>" required="">
                            <div class="invalid-feedback">
                                Valid name is required.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="type">Type</label>
                            <input type="text" class="form-control" id="type" name="type" placeholder="" value="<?php echo $post['_type'];?>" required="">
                            <div class="invalid-feedback">
                                Valid type is required.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="created">Created</label>
                            <input type="text" class="form-control" id="created" name="created" placeholder="" value="<?php echo $post['_created'];?>" required="">
                            <div class="invalid-feedback">
                                Valid type is required.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="modified">Modified</label>
                            <input type="text" class="form-control" id="modified" name="modified" placeholder="" value="<?php echo $post['_modified'];?>" required="">
                            <div class="invalid-feedback">
                                Valid type is required.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="Accessed">Accessed</label>
                            <input type="text" class="form-control" id="accessed" name="accessed" placeholder="" value="<?php echo $post['_accessed'];?>" required="">
                            <div class="invalid-feedback">
                                Valid type is required.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="size">Size</label>
                            <input type="text" class="form-control" id="size" name="size" placeholder="" value="<?php echo $post['_size'];?>" required="">
                            <div class="invalid-feedback">
                                Valid type is required.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="" value="<?php echo $post['_author'];?>" required="">
                            <div class="invalid-feedback">
                                Valid type is required.
                            </div>
                        </div>
                    <?php endif;?>

                    <hr class="mb-4">
                    <button class="btn btn-primary btn-lg btn-block" type="submit">Enviar</button>
                </form>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© 2018</p>
        </footer>
    </div>

    </body>
</html>
