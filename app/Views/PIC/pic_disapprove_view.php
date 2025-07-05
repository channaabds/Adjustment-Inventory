<!DOCTYPE html>
<html>
<head>
    <title>Disapprove Data</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h1>Disapprove Data</h1>

    <form action="PIC/pic/disapprove_update/<?= $item['id']; ?>" method="post" class="mb-5">
        <div class="form-group">
            <label for="remark">Remark</label>
            <textarea id="remark" name="remark" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Disapprove</button>
    </form>
</div>

</body>
</html>
