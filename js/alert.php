<?php
if (isset($_SESSION['status'])) {
    ?>
<script>
swal({
    title: "<?php echo $_SESSION['status']; ?>",
    text: "You clicked the button!",
    icon: "success",
    button: "okay",
});
</script>
<?php
}
