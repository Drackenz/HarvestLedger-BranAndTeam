<section class="delivery-form">
    <h2>Add delivery</h2>

    <?php if (count($errors) > 0): ?>
        <div class="error-box">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <label for="txtProducerName">Producer name</label>
        <input type="text" id="txtProducerName" name="producerName" placeholder="e.g. Juan Perez">

        <label for="txtWeight">Weight (quintals)</label>
        <input type="text" id="txtWeight" name="weightQuintals" placeholder="e.g. 5.5">

        <label for="cmbQualityGrade">Quality grade</label>
        <select id="cmbQualityGrade" name="qualityGrade">
            <option value="">-- Select a grade --</option>
            <option value="A">Grade A</option>
            <option value="B">Grade B</option>
            <option value="C">Grade C</option>
        </select>

        <label for="txtPricePerQuintal">Price per quintal (US$)</label>
        <input type="text" id="txtPricePerQuintal" name="pricePerQuintal" placeholder="e.g. 120.00">

        <button type="submit" name="addDelivery">Add delivery</button>
    </form>
</section>