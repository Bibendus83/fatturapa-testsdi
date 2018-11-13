	@include('ui::header')
	
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <h1 class="navbar-brand">FatturaPA testUI - Trasmittente / destinatario {{$actor}}</h1>
      <span id="dateTime"></span>
    </nav>

    <div id="wrapper">
        <!-- Sidebar -->
    @include('ui::sidebar') 

    <div id="content-wrapper">
      <div class="container-fluid" id="tables" v-cloak>
        <div class="actions row">
          <div class="col-sm">
            <button type="button" v-on:click="dispatch();" class="btn mb-1 btn-primary">Invia notifiche</button>
            <button type="button" onclick="post('/td{{$actor}}/rpc/clear');" class="btn mb-1 btn-danger">Resetta il database</button>
          </div>
        </div>        
        <!-- tabs -->
        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 20px;">
          <li class="nav-item">
            <a class="nav-link active" id="emissione-tab" data-toggle="tab" href="#emissione" role="tab" aria-controls="emissione" aria-selected="true">Emissione</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="ricezione-tab" data-toggle="tab" href="#ricezione" role="tab" aria-controls="ricezione" aria-selected="false">Ricezione</a>
          </li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane fade show active" id="emissione" role="tabpanel" aria-labelledby="emissione-tab">
            <!-- tab content emissione -->
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6 offset-sm-3">
                  <form enctype="multipart/form-data" class="form-group" id="upload-form">
                    <button type="button" class="btn btn-info btn-block" onclick="document.getElementById('inputFile').click()">Scegli fattura...</button>
                    <div class="form-group inputDnD">
                    <label class="sr-only" for="inputFile">File Upload</label>
                    <input type="file" name="File" class="form-control-file text-info font-weight-bold" id="inputFile" accept="text/xml" data-title="oppure trascina qui la fattura in formato XML" />
                    </div>
                    <p style="display: none;" class="fileMsg">È stato selezionato il file: <span class="fileName"></span></p>
                    <input type="submit" name="submit" v-on:click="refreshTables();" value="Carica" class="btn btn-primary btn-block" id="submit" disabled/>
                  </form>                  
                </div>
              </div> <!-- end row -->
            </div> <!-- end container-fluid -->
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm">
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_UPLOADED"
                    description="I_UPLOADED: ready to be transmitted to ES"
                    button="Trasmetti"
                    action="/rpc/transmit"
                    :home=home
                    title="Caricate"></invoice-table>
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_TRANSMITTED"
                    description="I_TRANSMITTED: transmitted to ES"
                    :home=home
                    title="Trasmesse"></invoice-table>
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_INVALID"
                    description="I_INVALID:	ES notified it was invalid"
                    :home=home
                    title="Invalide"></invoice-table>
                </div>
                <div class="col-sm">
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_DELIVERED"
                    description="I_DELIVERED: ES notified that it was delivered to Recipient"
                    :home=home
                    title="Consegnate"></invoice-table>
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_FAILED_DELIVERY"
                    description="I_FAILED_DELIVERY: failed delivery within 48 hours"
                    :home=home
                    title="Mancata consegna"></invoice-table>
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_IMPOSSIBLE_DELIVERY"
                    description="I_IMPOSSIBLE_DELIVERY: ES notified that it was not delivered to the recipient within 48 hours + 10 days"
                    :home=home
                    title="Consegna impossibile"></invoice-table>
                </div>
                <div class="col-sm">
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_ACCEPTED"
                    description="I_ACCEPTED: ES notified that it was not accepted by the recipient"
                    :home=home
                    title="Accettate"></invoice-table>
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_REFUSED"
                    description="I_REFUSED: ES notified that it was not refused by the recipient"
                    :home=home
                    title="Rifiutate"></invoice-table>
                  <invoice-table
                    endpoint="/rpc/invoices/?status=I_EXPIRED"
                    description="I_EXPIRED: ES notified that it was not accepted / refused by the recipient for more than 15 days"
                    :home=home
                    title="Termini scaduti"></invoice-table>
                </div>
              </div> <!-- end row -->
            </div> <!-- end container-fluid -->
          </div> <!-- end content tab emissione -->
          <div class="tab-pane fade" id="ricezione" role="tabpanel" aria-labelledby="ricezione-tab">
            <!-- start content tab ricezione -->
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-8">
                  <invoice-table2
                    endpoint="/rpc/invoices/?status=R_RECEIVED"
                    description="R_RECEIVED: received from ES"
                    :home=home
                    title="Ricevute"></invoice-table2>
                </div>
                <div class="col-sm">
                  <invoice-table
                    endpoint="/rpc/invoices/?status=R_ACCEPTED"
                    description="R_ACCEPTED: Accepted"
                    :home=home
                    title="Accettate"></invoice-table>
                  <invoice-table
                    endpoint="/rpc/invoices/?status=R_REFUSED"
                    description="R_REFUSED: Refused"
                    :home=home
                    title="Rifiutate"></invoice-table>
                  <invoice-table
                    endpoint="/rpc/invoices/?status=R_EXPIRED"
                    description="R_EXPIRED: ES notified that it was not accepted / refused by the recipient for more than 15 days"
                    :home=home
                    title="Termini scaduti"></invoice-table>
                </div>
              </div> <!-- end row -->
            </div> <!-- end container-fluid -->
          </div> <!-- end content tab ricezione -->
        </div> <!-- end tab content -->
      </div>  <!-- /.container-fluid -->
    </div> <!-- /.content-wrapper -->
    </div> <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <span>^</span>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>

        <script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/InvoiceTable.js"></script>
    <script type="text/javascript" src="js/InvoiceTable2.js"></script>
    
<script type="text/javascript">

  var app = new Vue({
    el: '#tables',
    data: {
      home: '/td{{$actor}}'
    },
    methods: {
      dispatch: function() {
        post(this.home + '/rpc/dispatch');
      },
      refreshTables: function() {
        EventBus.$emit('refreshTables');
      }
    }
  });
  document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");
  });

// disable submit button until right file is selected for upload

$(document).ready(function(){
    $('#inputFile').change(function(e){
            if ($(this).val()) {
                var fileName = this.files[0].name;
                var fileSize = this.files[0].size;
                var fileType = this.files[0].type; 
            }
            if((fileType != "text/xml") || (fileSize >  5242880)) {
              $('#submit').prop('disabled', true);
              Toastify({
                text: "Il file deve essere in formato XML e non superare i 5 Mb.",
                duration: 5000,
                close: true,
                gravity: "top",
                backgroundColor: "#f73e5a",
              }).showToast();
              $("#upload-form")[0].reset();
            } else {
              $('.fileName').html(fileName);
              $('#submit').attr('disabled',false);
              $('.fileMsg').show();
            }
        });        

    // asynchronous file upload and refresh tables

    $("#upload-form").on('submit', (function(ev) {
        var fileName = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
        ev.preventDefault();
        $.ajax({
            xhr: function() {
                var progress = $('.progress'),
                    xhr = $.ajaxSettings.xhr();
                progress.show();
                xhr.upload.onprogress = function(ev) {
                    if (ev.lengthComputable) {
                        var percentComplete = parseInt((ev.loaded / ev.total) * 100);
                        progress.val(percentComplete);
                        if (percentComplete === 100) {
                            progress.hide().val(0);
                        }
                    }
                };
                return xhr;
            },
            url: '/td{{$actor}}/rpc/upload',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data, status, xhr) {
                EventBus.$emit('refreshTables');
                $('.fileMsg').hide();
                Toastify({
                  text: "Il file " + fileName + " è stato caricato.",
                  duration: 5000,
                  close: true,
                  gravity: "top",
                  backgroundColor: "#00cc85",
                }).showToast();
                $('#submit').attr('disabled',true);  
                $("#upload-form")[0].reset();
            },
            error: function(xhr, status, error) {
                $("#upload-form")[0].reset();
                $('.fileMsg').hide();
                $('#submit').attr('disabled',true);
                Toastify({
                  text: "C'è stato un errore durante il caricamento del file " + fileName + ", riprova.",
                  duration: 5000,
                  close: true,
                  gravity: "top",
                  backgroundColor: "#f73e5a",                  
                }).showToast();
            }
       });
    }));
});
</script>
  

    <script src="js/bootstrap-italia.bundle.min.js"></script>
    <script src="js/bootstrap-italia.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
      
	@include('ui::footer')
