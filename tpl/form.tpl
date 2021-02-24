<h1>{event}</h1>
<p>{event_text}</p>
<hr>
{snippet_intro}

<form action="{formaction}" method="POST">
	
	<div class="form-group">
		<label>Name <span class="text-muted">*</span></label>
		<input class="form-control" name="name" type="text" value="{name}">
	</div>
	<div class="form-group">
		<label>Telefon <span class="text-muted">*</span></label>
		<input class="form-control" name="tel" type="text" value="{tel}">
	</div>
	
	<div class="row">
		<div class="col-md-9">
	<div class="form-group">
		<label>Straße</label>
		<input class="form-control" name="street" type="text" value="{street}">
	</div>
		</div>
		<div class="col-md-3">
	<div class="form-group">
		<label>Nr.</label>
		<input class="form-control" name="street_nbr" type="text" value="{street_nbr}">
	</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
	<div class="form-group">
		<label>PLZ</label>
		<input class="form-control" name="zip" type="text" value="{zip}">
	</div>
		</div>
		<div class="col-md-9">
	<div class="form-group">
		<label>Ort</label>
		<input class="form-control" name="city" type="text" value="{city}">
	</div>
		</div>
	</div>
	<hr>
	<small><span class="text-muted">* Pflichtfelder</span></small>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group form-check">
				<input type="checkbox" class="form-check-input" name="privacy_policy" id="privacy_policy">
				<label class="form-check-label" for="privacy_policy">{snippet_privacy_policy}</label>
			</div>
		</div>
		<div class="col-md-4">
			<input type="submit" name="checkin" value="Einchecken" class="btn btn-success btn-block">
		</div>
	</div>
	<input type="hidden" name="event_id" value="{event_id}">
</form>