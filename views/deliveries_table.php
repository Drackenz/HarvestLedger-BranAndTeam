<?php
$totalQuintals = 0;
$totalPaid = 0;
foreach ($deliveries as $delivery) {
    $totalQuintals += $delivery->weightQuintals;
    $totalPaid += $delivery->amountPayable;
}
?>
<section class="deliveries-table">
    <h2>Today's deliveries</h2>

    <form method="GET" action="index.php" class="search-bar">
        <input type="text" name="search" id="txtSearchTerm" placeholder="Search by producer name" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button type="submit">Search</button>
    </form>

    <?php if (count($allDeliveries) == 0): ?>
        <p class="empty-state">No deliveries yet. Add your first delivery to get started.</p>
    <?php elseif (count($deliveries) == 0): ?>
        <p class="empty-state">No deliveries match your search.</p>
    <?php else: ?>
        <table id="dgvDeliveries">
            <tr>
                <th>Producer</th><th>Weight (qq)</th><th>Grade</th>
                <th>Price/qq</th><th>Amount payable</th><th>Date</th><th></th><th></th>
            </tr>
            <?php foreach ($deliveries as $index => $delivery): ?>
                <tr>
                    <td><?php echo htmlspecialchars($delivery->producerName); ?></td>
                    <td><?php echo $delivery->weightQuintals; ?></td>
                    <td><?php echo $delivery->qualityGrade; ?></td>
                    <td><?php echo number_format($delivery->pricePerQuintal, 2); ?></td>
                    <td><?php echo number_format($delivery->amountPayable, 2); ?></td>
                    <td><?php echo $delivery->date; ?></td>
                    <td><a href="views/receipt.php?id=<?php echo $index; ?>" target="_blank">Print receipt</a></td>
                    <td><a href="index.php?deleteId=<?php echo $index; ?>" onclick="return confirm('Delete this delivery? This cannot be undone.');">Delete</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <p id="lblTotalQuintals">Total quintals: <?php echo number_format($totalQuintals, 2); ?></p>
        <p id="lblTotalPaid">Total paid: US$ <?php echo number_format($totalPaid, 2); ?></p>

        <form method="POST" action="index.php" onsubmit="return confirm('Clear all deliveries? This cannot be undone.');">
            <button type="submit" name="clearSession" id="btnClearSession">Clear session</button>
        </form>
    <?php endif; ?>
</section>