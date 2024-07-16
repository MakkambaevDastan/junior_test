<?php

use Das\App\Repository\DB;
use Das\App\Repository\UserRepository;

require './vendor/autoload.php';
require 'env.php';
session_start();
if (empty($_SESSION['user'])) {
    header('Location: /login.php');
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Board</title>
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/jquery-3.6.0/jquey-3.6.0.min.js"></script>
    <script src="assets/"></script>
</head>

<body class="bg-gradient">
    <nav class="navbar navbar-light bg-light shadow rounded py-2 mb-3">
        <div class="container-fluid">
            <ul class="nav">
                <li class='nav-item'><a class='nav-link navbar-brand' href='logout.php'>Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container bg-light bg-gradient shadow-lg rounded p-2">
        <?php
        $page = empty($_POST['page']) ? 1 : (int)$_POST['page'];
        $size = empty($_POST['size']) ? 10 : (int)$_POST['size'];
        $sort = empty($_POST['sort']) ? "username" : $_POST['sort'];
        $asc = empty($_POST['asc']) ? 'asc' : $_POST['asc'];

        $db = new DB();
        $userRepo = new UserRepository($db);
        $users = $userRepo->getPage($page, $size, $sort, $asc);

        $page = (int)$users['page'];
        $size = (int)$users['size'];
        $sort = $users['sort'];
        $asc = $users['asc'];
        $count = (int)$users['count'];
        $list = $users['list'];
        // $pages = intdiv($count, $size) + ($count % $size > 0 ? 1 : 0);
        $pages = intdiv($count, $size) + ($count % $size > 0 ? 1 : 0);
        ?>
        <form action="admin.php" method="post" id="form">
            <nav aria-label="...">
                <ul class="pagination">
                    <li class="page-item ">
                        <select class="form-select page-link-lg  hover cursor-pointer" name="size" id="size">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </li>
                    <li class="page-item">
                        <select class="form-select page-link-lg  hover cursor-pointer" name="asc" id="asc">
                            <option value="asc">Asc</option>
                            <option value="desc">Desc</option>
                        </select>
                    </li>
                    <li class="page-item">
                        <select class="form-select page-link-lg  hover cursor-pointer" name="sort" id="sort">
                            <option value="iduser">ID</option>
                            <option value="username">Username</option>
                            <option value="idperson">IDPerson</option>
                            <option value="name">Name</option>
                            <option value="surname">Surname</option>
                            <option value="birthday">Birthday</option>
                        </select>
                    </li>
                    <li class="page-item"><a class="page-link page hover cursor-pointer" onclick="submit()">Sorting</a></li>
                </ul>
            </nav>
            <input type="number" name="page" id="page" hidden value="<?php echo $page ?>">
        </form>
        <table class="table table-striped table-bordered table-hover table-sm data" id="table">
            <thead class="thead-dark">
                <tr>

                    <th id="id" class="head" data-type="number" scope="col">ID </th>
                    <th id="username" value="username" class="head" data-type="string" scope="col">Username </th>
                    <th id="idperson" class="head" data-type="string" scope="col">IDPerson </th>
                    <th id="name" class="head" data-type="string" scope="col">Name </th>
                    <th id="surname" class="head" data-type="string" scope="col">Surname </th>
                    <th id="birthday" class="head" data-type="date" scope="col">Birthday </th>
                    <th id="sex" class="head" data-type="string" scope="col">Gender </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($list as $key => $value) {
                    echo '<tr>';
                    echo '<td name="iduser">' . $value['iduser'] . '</td>';
                    echo '<td name="username">' . $value['username'] . '</td>';
                    echo '<td name="idperson">' . $value['idperson'] . '</td>';
                    echo '<td name="name" class="data  hover cursor-pointer">' . $value['name'] . '</td>';
                    echo '<td name="surname" class="data  hover cursor-pointer">' . $value['surname'] . '</td>';
                    echo '<td name="birthday" class="date  hover cursor-pointer" >' . $value['birthday'] . '</td>';
                    echo '<td name="sex" class="select  hover cursor-pointer">' . $value['sex'] . '</td>';
                    echo '<td> ';
                    echo '<button type="button" class="btn btn-danger delete"> Delete </button>';
                    echo '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <nav aria-label="...">
            <ul class="pagination">
                <?php if ($page === 1) {
                    echo '<li class="page-item disabled">
                            <span class="page-link">Previous</span></li>';
                } else {
                    echo '<li class="page-item"><a class="page-link  hover cursor-pointer" onclick="pre(' . $page . ')">Previous</a></li>';
                };
                for ($i = 1; $i <= $pages; $i++) {
                    if ($i == $page) {
                        echo ' <li class="page-item active" aria-current="page">
                                <span class="page-link">' . $page . '</span></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link page hover cursor-pointer"  onclick="pageGO(' . $i . ')">' . $i . '</a></li>';
                    }
                }
                if ($page == $pages) {
                    echo '<li class="page-item" disabled>
                            <span class="page-link">Next</span></li>';
                } else {
                    echo '<li class="page-item">
                    <a class="page-link cursor-pointer" onclick="next(' . $page . ')">Next</a></li>';
                }
                echo '<li class="page-item disabled">
                            <span class="page-link">';
                echo $page * $size;
                echo ' from ';
                echo $count;
                echo '</span></li>';
                ?>
                    <li class="page-item">
                        <a class="page-link page hover cursor-pointer" type="button" id="add" onclick="add()">
                            Add new user
                        </a>
                    </li>
            </ul>
        </nav>
    </div>

   <script>
        $(document).ready(function() {
            $('#size').val(<?php echo $size ?>);
            $('#asc').val('<?php echo $asc ?>');
            $('#sort').val('<?php echo $sort ?>');
        });

        function submit() {
            $('#form').submit();
        }

        function pageGO(page) {
            $('#page').val(page);
            submit();
        }

        function next(page) {
            pageGO(page + 1);
        }

        function pre(page) {
            pageGO(page - 1);
        }
        $(document).on('dblclick', 'td.data', function() {
            if ($(this).children().length == 0) {
                var content = $(this).html();
                $(this).html('<input autofocus class="update"  value="' + content + '" />');
            }
        });
        $(document).on('dblclick', 'td.date', function() {
            if ($(this).children().length == 0) {
                var content = $(this).html();
                $(this).html('<input autofocus class="update"  type="date" value="' + content + '" />');
            }
        });
        $(document).on('dblclick', 'td.select', function() {
            if ($(this).children().length == 0) {
                var content = $(this).html();
                $(this).html('<select class="sex update" name="select">\
            <option value="null">null</option>\
            <option value="male">male</option>\
            <option value="female">female</option> </select>');
            }
        });

        $(document).on('focusout', 'input.update', function() {

            var content = $(this).val();

            $(this).html(content);

            let value = $(this).parent().parent().children();

            $(this).contents().unwrap();

            console.log(value);

            let iduser = value[0].innerHTML;
            let username = value[1].innerHTML;
            let idperson = value[2].innerHTML;
            let name = value[3].innerHTML;
            let surname = value[4].innerHTML;
            let birthday = value[5].innerHTML;
            let sex = value[6].innerHTML;

            let user = {
                iduser: iduser,
                username: username,
                idperson: idperson,
                name: name,
                surname: surname,
                birthday: birthday,
                sex: sex,
            };
            console.log('user: ', user);

            $.ajax({
                url: 'update.php',
                method: 'post',
                dataType: 'json',
                data: user,
                success: function(data) {
                    console.log('response: ', data);
                },
                error: function(error) {
                    console.log('error: ', error);
                }
            });
        });
        $(document).on('focusout', '.select', function() {
            var content = $(this).parent().children().find(":selected").val();
            let list = $(this).parent().children()[6];
            list.removeChild(list.firstElementChild);
            $(this).parent().children()[6].innerHTML = content;
        });

        $(document).on('click', '.delete', function() {
            if (!confirm("Do you want to delete")) {
                return false;
            }
            let data = {
                iduser: $(this).parents('tr').children()[0].innerHTML
            }
            console.log(data);
            $.ajax({
                url: 'delete.php',
                method: 'post',
                dataType: 'json',
                data: data,
            });
            $(this).parents('tr').remove();
        });

        function add() {
            $('#table').append(
                '<tr><td></td>\
                <td class="usernamedata">\
                <input type="text" style="boder:5px solid red" class="usernameinput" autofocus id="usernameEdit" />\
                <input type="button" class="usernamesubmit btn" id="usernamesubmit btn " value="Add"/>\
                </td>\
                <td></td>\
                <td class="data"></td>\
                <td class="data"></td>\
                <td class="date"></td>\
                <td class="select"></td>\
                <td><button type="button" class="btn btn-danger delete"> Delete </button></td></tr>');
        }

        $(document).on('input', 'input.usernameinput', function() {
            let data = {
                username: $(this).val()
            }

            $.ajax({
                url: 'check.php',
                method: 'post',
                dataType: 'json',
                data: data,
                success: function(data) {
                    if (data) {
                        $('input.usernameinput').css('border', '5px solid green');
                        $('input.usernamesubmit').css('background', 'green');
                        $("input.usernamesubmit").attr("disabled", false);
                        $('input.usernamesubmit').css('color', 'white');
                    } else {
                        $('input.usernameinput').css('border', '5px solid red');
                        $('input.usernamesubmit').css('background', 'red');
                        $("input.usernamesubmit").attr("disabled", true);
                    }
                }
            });
        });

        $(document).on('click', 'input.usernamesubmit', function() {


            let password = prompt("Please enter password");
            if (password == null) return;
            let data = {
                username: $('input.usernameinput').val(),
                password: password
            }
            $.ajax({
                url: 'add.php',
                method: 'post',
                dataType: 'json',
                data: data,
                success: function(data) {
                    location.reload(true);
                },
                error: function(error) {
                    console.log('error: ', error);
                }
            });
        });
    </script> 
</body>
</html>