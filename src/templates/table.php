<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лабораторная 3 - Автомобили</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Список автомобилей</h2>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Марка</th>
                        <th>Модель</th>
                        <th>Год выпуска</th>
                        <th>Цвет</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['cars'] as $car): ?>
                        <tr>
                            <td><?= (string)$car['id'] ?></td>
                            <td><?= (string)$car['brand'] ?></td>
                            <td><?= (string)$car['model'] ?></td>
                            <td><?= (string)$car['year'] ?></td>
                            <td><?= (string)$car['color'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>