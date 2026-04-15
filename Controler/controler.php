    <?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = new UserController();

        if (isset($_POST["login"])) {
            //echo "<p>Login button is clicked.</p>";
            $user->login();
        }
        if (isset($_POST["logout"])) {
            //echo "<p>Login button is clicked.</p>";
            $user->logout();
        }
        if (isset($_POST["register"])) {
            //echo "<p>Login button is clicked.</p>";
            $user->registro();
        }
    }
    class UserController{
         public $email;
         public $usuario;
         public $pass;
         public $pass2;
         public $rol;
         public $conn;
        
        public function __construct( )
        {          
        }


        public function registro(){
            $this->email = $_POST['email'];
            $this->usuario = $_POST['username'];
            $this->pass = $_POST['password'];
            $this->pass2 = $_POST['repeat-password'];
            $this->rol = $_POST['role'];

            $mensaje = "";

            if ($this->pass !== $this->pass2) {
                $mensaje = "Error: Las contraseñas no coinciden.";
                echo $mensaje;
            }else{
               // $mensaje = "Registro exitoso para el usuario: " . htmlspecialchars($this->usuario);
               // echo $mensaje;
                //echo "<br>Usuario creado: " . $this->usuario;
                if ($this->rol === "Cliente") {
                header("Location: ../View/Cliente.html");
                exit();
                }
                else if ($this->rol === "Promotor") {
                header("Location: ../View/Promotor.html");
                exit();

                }
                else{
                    echo "Error: En cargar la pagina";
                }
            }
        }   
        public function login() {
            $this->usuario = $_POST['usuario'];
            $this->pass = $_POST['password'];
            $this->rol = $_POST['role'];
            //echo "Intentando entrar como: " . htmlspecialchars($this->usuario);
            if ($this->rol === "Cliente") {
                header("Location: ../View/Main_Cliente.html");
            }else if ($this->rol === "Promotor") {
                header("Location: ../View/Main_Promotor.html");
            }else{
                echo "Usuario no existe";
            }
        }  
        
        public function logout(){
            session_destroy();
            echo "Sesión cerrada.";
        }
    }

?>