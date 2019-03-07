<!-- alert -->
<div id="alert" class="modal in" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <p></p>
		<textarea id="featureToAdd" class="hidden" placeholder="Waiting For Data.."></textarea>
		<div id="imageToAdd" class="row hidden">			
			<div class="col-xs-12">
			<input type="file" accept="image/*" name="uploadImage" id="uploadImage" tabindex="-1"/>			
			</div>
		</div>
        <div class="row">
            <div class="col-xs-12 text-center">
				<div class="yesNo">
					<button id="alertYes" class="btn btn-success btn-md">Yes</button>
					<button id="alertNo" class="btn btn-danger btn-md">No</button>
				</div>
				<div class="ok hidden">
					<button id="ok" class="btn btn-success btn-md">Ok</button>
				</div>
				<div class="addCancel hidden">
					<button id="add" class="btn btn-success btn-md">Add</button>
					<button id="cancel" class="btn btn-danger btn-md">Cancel</button>
				</div>
            </div>
        </div>
      </div>
   
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->