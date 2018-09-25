<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<a href="<?= site_url($current['controller'] . '/create') ?>" class="btn btn-primary">
  Add New
</a>
<table class="table table-bordered table-striped datatable table-model">
</table>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
  window.onload = function () {
    $('.table-model').DataTable({
      bProcessing: true,
      aaData: <?= json_encode($records) ?>,
      aoColumns: <?= json_encode($thead) ?>,
      fnRowCallback: function(nRow, aData, iDisplayIndex ) {
        $(nRow).css('cursor', 'pointer').click( function () {
          window.location.href = '<?= site_url($current['controller']) ?>/read/' + aData.uuid
        })
      }
    })
  }
</script>