	@include('ui::header')

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <h1 class="navbar-brand">FatturaPA testUI - Sistema di Interscambio</h1>
      <span id="dateTime"></span>
    </nav>

    <div id="wrapper">
    
    <!-- Sidebar -->
    @include('ui::sidebar') 

    <div id="content-wrapper">
      <div class="container-fluid" id="tables">
        <div class="actions row">
          <div class="col-sm">
            <button type="button" v-on:click="dispatch();" class="btn mb-1 btn-primary">Invia notifiche</button>
            <button type="button" onclick="post('/sdi/rpc/clear');" class="btn mb-1 btn-danger">Resetta il database</button>
          </div>
        </div>
        <div class="row">
          <div class="col-sm">
            <invoice-table
              endpoint="/rpc/invoices/?status=E_RECEIVED"
              description="E_RECEIVED: received from transmitter"
              button="Valida"
              action="/rpc/checkValidity"
              :home=home
              title="Ricevute"></invoice-table>
            <invoice-table
              endpoint="/rpc/invoices/?status=E_INVALID"
              description="E_INVALID: did not pass test"
              :home=home
              title="Invalide"></invoice-table>
          </div>
          <div class="col-sm">
            <invoice-table
              endpoint="/rpc/invoices/?status=E_VALID"
              description="E_VALID: passed checks"
              button="Consegna"
              action="/rpc/deliver"
              :home=home
              title="Valide"></invoice-table>
            <invoice-table
              endpoint="/rpc/invoices/?status=E_FAILED_DELIVERY"
              description="E_FAILED_DELIVERY: failed delivery within 48 hours"
              :home=home
              title="Mancata consegna"></invoice-table>
            <invoice-table 
              endpoint="/rpc/invoices/?status=E_IMPOSSIBLE_DELIVERY"
              description="E_IMPOSSIBLE_DELIVERY: failed delivery within 48 hours + 10 days"
              :home=home
              title="Consegna impossibile"></invoice-table>
          </div>
          <div class="col-sm">
            <invoice-table
              endpoint="/rpc/invoices/?status=E_DELIVERED"
              description="E_DELIVERED: delivered to recipient"
              button="Verifica termini"
              action="/rpc/checkExpiration"
              :home=home
              title="Consegnate"></invoice-table>
            <invoice-table
              endpoint="/rpc/invoices/?status=E_ACCEPTED"
              description="E_ACCEPTED: Recipient notified that it accepted the invoice"
              :home=home
              title="Accettate"></invoice-table>
            <invoice-table
              endpoint="/rpc/invoices/?status=E_REFUSED"
              description="E_REFUSED: Recipient notified that it refused the invoice"
              :home=home
              title="Rifiutate"></invoice-table>
            <invoice-table
              endpoint="/rpc/invoices/?status=E_EXPIRED"
              description="E_EXPIRED: not accepted / refused by the recipient for more than 15 days"
              :home=home
              title="Termini scaduti"></invoice-table>
          </div>
        </div>  <!-- /.row -->
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
          home: '/sdi'
        },
        methods: {
          dispatch: function() {
            post(this.home + '/rpc/dispatch');
          }
        }
      });
      document.addEventListener('DOMContentLoaded', function() {
        console.log("DOM fully loaded and parsed");
      });
    </script>

      <script src="js/bootstrap-italia.bundle.min.js"></script>
    <script src="js/bootstrap-italia.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    @include('ui::footer')
    
    
         
