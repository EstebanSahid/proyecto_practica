<?php
include '../Conexion/conexion.php';

$index = $pdo->prepare("SELECT 
                        e.*,
                        m.*,
                        IF(e.ev_nota = null,0,e.ev_nota) as nota,
                        CONCAT(es.est_primerApellido,' ', es.est_segundoApellido, ' ', es.est_primerNombre) as estudiante,
                        es.*,
                        c.cu_nombre
                        FROM evaluacion e 
                        INNER JOIN matricula m ON e.mat_id = m.mat_id
                        INNER JOIN estudiante es ON es.est_id = m.est_id
                        INNER JOIN cursoxdocente cxd ON cxd.cxd_id = m.cxd_id
                        INNER JOIN cursos c ON c.cu_id = cxd.cu_id ");
$index -> execute();
$listaEvaluaciones = $index->fetchAll(PDO::FETCH_ASSOC);


/*if(isset($_GET['guardado'])) {
    if ($_GET['guardado'] == "true") {
        echo '  <script>
                    alert("La inserción fue exitosa.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante la inserción.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}

if(isset($_GET['editado'])) {
    if ($_GET['editado'] == "true") {
        echo '  <script>
                    alert("Modificado Exitosamente.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante la Modificación del Registro.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}

if(isset($_GET['eliminado'])) {
    if ($_GET['eliminado'] == "true") {
        echo '  <script>
                    alert("Eliminado Exitosamente.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante al Eliminar  el Registro.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}*/
//print_r($listaEvaluaciones);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Basic -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Site Metas -->
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>ACME</title>

        <!-- slider stylesheet -->
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

        <!-- bootstrap core css -->
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

        <!-- fonts style -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../css/style.css" rel="stylesheet" />
        <!-- responsive style -->
        <link href="../css/responsive.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script defer src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
        <script defer src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>
    </head>

    <body>
        <div class="hero_area">
            <!-- Menu -->
            <?php include 'header.html'; ?>
            <!-- Menu -->
        </div>

        <!-- Tabla -->
        <div class="container pt-4">
            <div class="row">
                <div class="custom_heading-container">
                    <h3>
                        Evaluación
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4 d-flex justify-content-end service_container">
                    <div class="d-flex justify-content-center contact_section">
                        <button id="agregarevaluacionBtn">
                            Agregar Evaluacion
                        </button>
                    </div>
                </div>
            </div>

            <div class="row pt-4">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Estudiante</th>
                            <th class="text-center">Curso</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Nota</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <?php foreach($listaEvaluaciones as $evaluacion){ ?>
                        <tr>
                            <td class="text-center"><?= $evaluacion['estudiante']; ?></td>
                            <td class="text-center"><?= $evaluacion['cu_nombre']; ?></td>
                            <td class="text-center"><?= (isset($evaluacion['ev_nota']) ? "Finalizado" : "Pendiente") ?></td>
                            <td class="text-center"><?= (isset($evaluacion['ev_nota']) ? $evaluacion['ev_nota'] : "-") ?></td>
                            <td class="align-middle"> 
                                <div class="d-flex justify-content-center contact_crud">
                                    <?php if(isset($evaluacion['ev_nota'])){ ?>
                                        <button class="verEvaluacionBtn btn btn-primary mr-2"
                                            data-id="<?= $evaluacion["ev_id"]; ?>"
                                            >
                                        Ver evaluación
                                    </button>
                                    <?php }else{ ?>
                                        <button class="realizarEvaluacionBtn btn btn-primary mr-2"
                                            data-id="<?= $evaluacion['ev_id'];?>">
                                        Realizar
                                    </button>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <!-- Tabla -->

        <!-- footer section -->
        <section class="container-fluid footer_section">
            <p>
                Copyright &copy; 2019 All Rights Reserved By
                <a href="https://html.design/">Free Html Templates</a>
            </p>
        </section>
        <!-- footer section -->

        <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>

        <!-- Modales -->

        <!-- Modal Agregar -->
        <div class="modal" tabindex="-1" id="modalAdd">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nueva evaluacion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/evaluacionController.php" method="post">
                            <div class="row">
                                <input type="hidden" name="txt_id">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_nombre" placeholder="" name="txt_nombre" required>
                                        <label for="txt_nombre">evaluacion</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_RUC" placeholder="" id="txt_RUC" required>
                                        <label for="txt_RUC">RUC</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_telef" placeholder="" id="txt_telef" required>
                                        <label for="txt_telef">Telefono</label>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_dir" placeholder="" id="txt_dir" required><br> 
                                        <label for="txt_dir">Dirección</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnAgregar" type="submit" name="accion" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Visualizar -->
        <div class="modal" tabindex="-1" id="modalVisualizar">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Evaluación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <section id="modal_visualizar_evaluacion"></section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Realizar Evaluacion -->
        <div class="modal" tabindex="-1" id="modalrealizar">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Realizar Evaluación</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <section id="modal_realizar_evaluacion"></section>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modales -->

        <!-- Scripts -->
        <script>
            $(document).ready(function() {
                // Inicializar DataTable
                $('#example').DataTable();

                //Abrir el Modal para Agregar
                $('#agregarevaluacionBtn').click(function(){
                    console.log("click aqui")
                    $('#modalAdd').modal('show');
                });

                //Abrir Visualizar
                $('.verEvaluacionBtn').click(function(){
                    console.log("clic")
                    $('#modalVisualizar').modal('show');
                });

                //Abrir Realizar
                $('.realizarEvaluacionBtn').click(function(){
                    console.log("clic")
                    $('#modalrealizar').modal('show');
                });
            });
        </script>
        <!-- Scripts -->
    </body>
</html>