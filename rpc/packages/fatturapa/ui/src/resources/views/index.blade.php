@include('ui::header')
		
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <h1 class="navbar-brand">FatturaPA testUI - Dashboard</h1>
  <span id="dateTime"></span>
</nav>
<div id="wrapper">   	
<!-- Sidebar -->
	@include('ui::sidebar') 
	<div id="content-wrapper">
	  <div class="container-fluid">
	    <div class="card col-md-6">
	      <div class="card-body">
	        <div class="form-group">
	          <p>Vuoi resettare le impostazioni di data e ora?</p>
	          <button type="button" onclick="post('/sdi/rpc/resetTime');" class="btn mb-1 btn-primary">Ok, resetta data e ora</button>
	        </div>
	        <div class="form-group">
	          <p>Simula data e ora:</p>
	          <div>
	            <input id="date" type="date" class="form-control" aria-label="date">
	            <input id="time" type="time" class="form-control" aria-label="time">
	            <input id="dt" type="datetime-local" hidden>
	            <button type="button" class="btn mb-1 btn-primary" id="saveDatetime">Salva</button>
	          </div>
	        </div>  
	        <div class="form-group">
	          <p>Imposta fattore per il tempo simulato (da 1 a 1000000000):</p>
	          <div class="input-group">
	            <input id="speed" type="number" min="1" max="1000000000" class="form-control" aria-label="speed">
	            <button type="button" onclick="post('/sdi/rpc/speed', 'speed', 'speed');" class="btn mb-1 btn-primary">Salva</button>
	          </div>
	        </div>
	      </div>  <!-- /.card-body -->
	    </div>  <!-- /.card mb-3 -->    
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
	// prefill date time speed form
	$(document).ready(function(){
	    var url = window.location.protocol + "//" + window.location.host + "/";
	    url = url + "sdi/rpc/datetime";
	    $.ajax({
	    url: url,
	    dataType: 'json',
	    success: function( data ) {
	        var dateTime = data.datetime;
	        var date = dateTime.substr(0, 10); //yyyy-mm-dd        
	        var time = dateTime.substr(11, 5); //00:00
	        // var dt = date+"T"+time; //yyyy-mm-ddT00:00
	        $('#date').val(date);
	        $('#time').val(time);
	
	        var speed = data.speed;
	        $('#speed').val(speed);
	    },
	    error: function( data ) {
	            Toastify({
	              text: "Errore nel prefill form (" + url + "), riprova.",
	              duration: 5000,
	              close: true,
	              gravity: "top",
	              backgroundColor: "#f73e5a",
	            }).showToast(); 
	    }
	  });
	});
	//compose and post datetime
	$(document).ready(function(){
	  $("#saveDatetime").click(function() {
	    var date = $("#date").val();
	    var time = $("#time").val();
	    var dt = date+"T"+time;
	    $("#dt").val(dt);
	    post('/sdi/rpc/timestamp', 'timestamp', 'dt');
	    refreshClock();
	  });
	});
	</script>

    <script src="js/bootstrap-italia.bundle.min.js"></script>
    <script src="js/bootstrap-italia.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    
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

@include('ui::footer')
