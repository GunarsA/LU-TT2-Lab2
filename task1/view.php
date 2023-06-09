<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Automobile statistics</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <h1>Automobile statistics tool</h1>
    <form method="GET" action="index.php">
        <fieldset>
            <legend>Filtering options</legend>

            <?php if (isset($error)) { ?>
                <div class="error">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php } ?>

            <select name="manufacturer" id="manufacturer">
                <option value="">Pick a brand</option>
                <?php foreach ($manufacturers as $id => $title) { ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></option>
                <?php } ?>
            </select>

            <select name="color" id="color">
                <option value="">Pick a color</option>
                <?php foreach ($colors as $id => $title) { ?>
                    <option value="<?php echo $id; ?>"><?php echo htmlspecialchars($title); ?></option>
                <?php } ?>
            </select>

            <label for="year">Production year</label>
            <input type="number" name="year" min="2010" max="2020" />

            <button type="submit">Apply filters </button>
        </fieldset>

    </form>

    <section id="main">
        <?php if (sizeof($results) > 0) {
        ?>
            <table>
                <tr>
                    <th>Brand/Manufacturer</th>
                    <th>Model</th>
                    <th>Count</th>
                </tr>

                <!-- TODO: Output a table row for each result line -->
                <?php foreach ($results as $result) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($result["manufacturer"]); ?></td>
                        <td><?php echo htmlspecialchars($result["model"]); ?></td>
                        <td><?php echo htmlspecialchars($result["count"]); ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php
        }
        ?>
    </section>

</body>

</html>