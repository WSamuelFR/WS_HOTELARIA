<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Cadastro Clientes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e7f1ff;
        }

        header {
            background: #ffcc00;
            color: #0056b3;
            padding: 20px 0;
            border-bottom: #77d7ff 3px solid;
        }

        header h1 {
            color: #0056b3;
            text-transform: uppercase;
            font-weight: bold;
            font-size: 24px;
        }

        header nav .nav-link {
            color: #0056b3;
            font-weight: bold;
        }

        header nav .nav-link:hover {
            color: #e6b800;
        }

        .tab-content {
            padding: 20px;
            background: #fff;
            border: 1px solid #77d7ff;
            margin-top: 20px;
            border-radius: 8px;
        }

        .nav-tabs .nav-link.active {
            background-color: #e6b800;
            color: #0056b3;
            border-color: #77d7ff #77d7ff #fff;
            font-weight: bold;
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 10px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            border-radius: 5px;
        }

        /* Ajustes de estilo para o menu minimizado */
        .offcanvas {
            margin-top: 177px;
            background-color: #ffcc00;
            /* Cor de fundo escura */
            color: #0056b3;
            /* Cor do texto */
            width: 250px;
        }

        .offcanvas-minimized {
            margin-top: 177px;
            width: 70px;
            overflow-x: hidden;
        }

        .offcanvas a {
            color: #f8f9fa;
            /* Cor dos links */
        }

        .offcanvas a:hover {
            color: #ffc107;
            /* Cor dos links ao passar o mouse */
        }

        .offcanvas-header {
            border-bottom: 1px solid #495057;
            /* Linha de separação */
        }

        .btn-icon {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            text-align: left;
        }

        .btn-icon i {
            font-size: 2.5rem;
            /* Ajuste o tamanho dos ícones */
        }
    </style>
</head>

<body>

    <header>
        <div class="container text-center">
        <h1>WS-HOTELARIA</h1>
            <h2>Cadastro de hospedes e empresas</h2>
            <nav class="nav justify-content-center mt-3">
                <button id="menuButton" class="nav-link btn btn-light border" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
                    Menu <i class="fas fa-bars"></i>
                </button>
                <a href="clientes.php" class="nav-link btn btn-light border">Cadastro</a>
                <a href="consulta.php" class="nav-link btn btn-light border">Consulta</a>
            </nav>
        </div>
    </header>

    <!-- Offcanvas minimizado com botões e ícones -->
    <div class="offcanvas offcanvas-start offcanvas-minimized" tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="staticBackdropLabel">Menu de Navegação</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <button class="nav-link btn btn-icon mb-2 btn-light border" onclick="window.location.href='clientes.php'">
                <i class="bi bi-person-plus">🪪</i>
                <span>Clientes</span>
            </button>
            <button class="nav-link btn btn-icon mb-2 btn-light border" onclick="window.location.href='reserva.php'">
                <i class="bi bi-search">📝</i>
                <span>Reservas</span>
            </button>
        </div>
    </div>


    <div class="container mt-4">
        <article>
            <ul class="nav nav-tabs" id="tabMenu" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="hospede-tab" data-bs-toggle="tab" data-bs-target="#hospede" type="button" role="tab" aria-controls="hospede" aria-selected="true">Hóspede</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="empresa-tab" data-bs-toggle="tab" data-bs-target="#empresa" type="button" role="tab" aria-controls="empresa" aria-selected="false">Empresa</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="hospede" role="tabpanel" aria-labelledby="hospede-tab">
                    <!-- Conteúdo da aba Hóspede -->
                    <div class="container mt-4">
                        <h2 class="text-center">Cadastro de Hóspedes</h2>
                        <form action="../hospede/inserir_hospede.php" method="POST">
                            <!-- Informações Pessoais -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2">Informações Pessoais</legend>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="first_name" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="last_name" class="form-label">Sobrenome</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="cpf" class="form-label">CPF</label>
                                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="rg" class="form-label">RG</label>
                                        <input type="text" class="form-control" id="rg" name="rg" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="birth_date" class="form-label">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="gender" class="form-label">Gênero</label>
                                        <select class="form-select" id="gender" name="gender" required>
                                            <option value="" disabled selected>Selecione</option>
                                            <option value="masculino">Masculino</option>
                                            <option value="feminino">Feminino</option>
                                            <option value="outro">Outro</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="ethnicity" class="form-label">Etnia</label>
                                        <select class="form-select" id="ethnicity" name="ethnicity" required>
                                            <option value="" disabled selected>Selecione</option>
                                            <option value="branco">Branco</option>
                                            <option value="negro">Negro</option>
                                            <option value="pardo">Pardo</option>
                                            <option value="indigena">Indígena</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Telefone</label>
                                        <input type="text" class="form-control" id="phone" name="phone" required>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Endereço -->
                            <fieldset class="border p-3 mb-4">
                                <legend class="w-auto px-2">Endereço</legend>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="birth_country" class="form-label">País de Nascimento</label>
                                        <input type="text" class="form-control" id="birth_country" name="birth_country" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="current_country" class="form-label">País Atual</label>
                                        <input type="text" class="form-control" id="current_country" name="current_country" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="state" class="form-label">Estado</label>
                                        <input type="text" class="form-control" id="state" name="state" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="city" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="city" name="city" required>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="neighborhood" class="form-label">Bairro</label>
                                        <input type="text" class="form-control" id="neighborhood" name="neighborhood" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="street" class="form-label">Rua</label>
                                        <input type="text" class="form-control" id="street" name="street" required>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="address" class="form-label">Número</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                    </div>
                                    <div class="col-md-2 mb-3">
                                        <label for="cep" class="form-label">CEP</label>
                                        <input type="text" class="form-control" id="cep" name="cep" required>
                                    </div>
                                </div>
                            </fieldset>

                            <!-- Botão de Envio -->
                            <center>
                                <button class="btn btn-outline-primary" type="submit" onclick="return confirm('Tem certeza que deseja salvar?');">Cadastrar Hospede</button>
                            </center>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="empresa" role="tabpanel" aria-labelledby="empresa-tab">
                    <!-- Conteúdo da aba Empresa -->
                    <div class="container mt-4">
                        <h2 class="text-center">Cadastro de Empresas</h2>
                        <form action="../Empresa/inserir_empresa.php" method="POST">
                            <div class="mb-3">
                                <label for="company_name" class="form-label">Nome da Empresa</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="cnpj" class="form-label">CNPJ</label>
                                <input type="text" class="form-control" id="cnpj" name="cnpj" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="founding_date" class="form-label">Data de Fundação</label>
                                <input type="date" class="form-control" id="founding_date" name="founding_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="sector" class="form-label">Setor</label>
                                <input type="text" class="form-control" id="sector" name="sector" required>
                            </div>
                            <center>
                                <button class="btn btn-outline-primary" type="submit" onclick="return confirm('Tem certeza que deseja salvar?');">Cadastrar Empresa</button>
                            </center>
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>

    <footer class="bg-light text-center py-3 mt-5">
        <p class="mb-0">© WS-HOTELARIA. Todos os direitos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>