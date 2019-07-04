<!DOCTYPE html>
<html lang="en">

<head>
  <?php $this->load->view("admin/_partials/head.php") ?>
</head>

<body id="page-top">

  <?php $this->load->view("admin/_partials/navbar.php") ?>
  <div id="wrapper">

    <?php $this->load->view("admin/_partials/sidebar.php") ?>

    <div id="content-wrapper">

      <div class="container-fluid">

        <?php //$this->load->view("admin/_partials/breadcrumb.php") ?>

        <!-- DataTables -->
        <div class="card mb-3">
          <div class="card-header">
            <a href="#" data-toggle="modal" data-target="#myModalAdd"><i class="fas fa-plus"></i> Add New</a>
          </div>
          <div class="card-body">

            <div class="table-responsive">
              <table class="table table-hover" id="mytable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>QR Code</th>
                    <th>Action</th>
                  </tr>
                </thead>
              </table>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <?php $this->load->view("admin/_partials/footer.php") ?>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Modal Add Product-->
  <form id="add-row-form" action="<?php echo site_url('crud/save');?>" method="post">
     <div class="modal fade" id="myModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title" id="myModalLabel">Add New</h4>
               </div>
               <div class="modal-body">
                   <div class="form-group">
                       <input type="text" name="product_code" class="form-control" placeholder="Product Code" required>
                   </div>
                                     <div class="form-group">
                       <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                   </div>
                                     <div class="form-group">
                       <select name="category" class="form-control" placeholder="Category" required>
                                                  <?php foreach ($category->result() as $row) :?>
                                                        <option value="<?php echo $row->category_id;?>"><?php echo $row->category_name;?></option>
                                                    <?php endforeach;?>
                                             </select>
                   </div>
                                     <div class="form-group">
                       <input type="text" name="price" class="form-control" placeholder="Price" required>
                   </div>

               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
               </div>
                </div>
        </div>
     </div>
 </form>

 <!-- Modal Update Product-->
  <form id="add-row-form" action="<?php echo site_url('crud/update');?>" method="post">
     <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title" id="myModalLabel">Update Product</h4>
               </div>
               <div class="modal-body">
                   <div class="form-group">
                       <input type="text" name="product_code" class="form-control" placeholder="Product Code" readonly>
                   </div>
                                     <div class="form-group">
                       <input type="text" name="product_name" class="form-control" placeholder="Product Name" required>
                   </div>
                                     <div class="form-group">
                       <select name="category" class="form-control" required>
                                                 <?php foreach ($category->result() as $row) :?>
                                                     <option value="<?php echo $row->category_id;?>"><?php echo $row->category_name;?></option>
                                                 <?php endforeach;?>
                                             </select>
                   </div>
                                     <div class="form-group">
                       <input type="text" name="price" class="form-control" placeholder="Price" required>
                   </div>

               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Update</button>
               </div>
                </div>
        </div>
     </div>
 </form>

 <!-- Modal delete Product-->
  <form id="add-row-form" action="<?php echo site_url('crud/delete');?>" method="post">
     <div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h4 class="modal-title" id="myModalLabel">Delete Product</h4>
               </div>
               <div class="modal-body">
                       <input type="hidden" name="product_code" class="form-control" required>
                                             <strong>Are you sure to delete this record?</strong>
               </div>
               <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-success">Yes</button>
               </div>
                </div>
        </div>
     </div>
 </form>

<?php $this->load->view("admin/_partials/js.php") ?>

  <script>
    $(document).ready(function(){
        // Setup datatables
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };
 
      var table = $("#mytable").dataTable({
          initComplete: function() {
              var api = this.api();
              $('#mytable_filter input')
                  .off('.DT')
                  .on('input.DT', function() {
                      api.search(this.value).draw();
              });
          },
              oLanguage: {
              sProcessing: "loading..."
          },
              processing: true,
              serverSide: true,
              ajax: {"url": "<?php echo base_url().'index.php/crud/get_product_json'?>", "type": "POST"},
                    columns: [
                                                {"data": "product_code"},
                                                {"data": "product_name"},
                                                //render number format for price
                        {"data": "product_price", render: $.fn.dataTable.render.number(',', '.', '')},
                        {"data": "category_name"},
                        {"data": "qrcode","render": function(data, type, row) {
                    return '<img src="<?php echo site_url('Crud/QRcode/') ?>'+(row['product_code'])+'" />';}},
                        {"data": "view"}
                  ],
                order: [[1, 'asc']],
                columnDefs: [ {
                'targets': [4,5], /* column index */
                'orderable': false, /* true or false */
                'searchable': false,
                }],
          rowCallback: function(row, data, iDisplayIndex) {
              var info = this.fnPagingInfo();
              var page = info.iPage;
              var length = info.iLength;
              $('td:eq(0)', row).html();
          }
 
      });
            // end setup datatables
            // get Edit Records
            $('#mytable').on('click','.edit_record',function(){
            var code=$(this).data('code');
                        var name=$(this).data('name');
                        var price=$(this).data('price');
                        var category=$(this).data('category');
            $('#ModalUpdate').modal('show');
            $('[name="product_code"]').val(code);
                        $('[name="product_name"]').val(name);
                        $('[name="price"]').val(price);
                        $('[name="category"]').val(category);
      });
            // End Edit Records
            // get delete Records
            $('#mytable').on('click','.delete_record',function(){
            var code=$(this).data('code');
            $('#ModalDelete').modal('show');
            $('[name="product_code"]').val(code);
      });
            // End delete Records
    });
</script>
</body>

</html>