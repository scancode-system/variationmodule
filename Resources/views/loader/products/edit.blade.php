<hr>
<h4>Quantidade Mínima por Variação</h4>

{{ Form::open(['route' => ['variation_mins.store', $product]]) }}
<div class="row">
	<div class="col-md-2">
		{{ Form::select('group', $groups, [], ['class' => 'form-control', 'placeholder' => 'Regras']) }}
	</div>
	<div class="col-md-3">
		{{ Form::select('variation_id', $variations->pluck('alias', 'id'), [], ['id' => 'variations', 'class' => 'form-control', 'placeholder' => 'Variações']) }}
	</div>
	<div class="col-md-3">
		{{ Form::select('', [], [],  ['id' => 'no-varation-picked', 'class' => 'form-control', 'placeholder' => 'Selecione a variação', 'disabled' => 'disabled']) }}
		@foreach($values_variations as $values_variation)
		{{ Form::select('value', $values_variation->values, [],  ['id' => $values_variation->id, 'class' => 'form-control', 'placeholder' => 'Escolha um(a) '.$values_variation->id, 'disabled' => 'disabled']) }}
		@endforeach
	</div>
	<div class="col-md-2">
		{{ Form::number('min_qty',  null, ['class' => 'form-control', 'step' => '1', 'placeholder' => 'Min.']) }}
	</div>
	<div class="col-md-2">
		{{ Form::button('<i class="fa fa-save float-left"></i><span>Salvar</span>', ['class' => 'w-100 btn btn-brand btn-primary', 'type' => 'submit']) }}
	</div>
</div>
{{ Form::close() }}

<div class="d-flex justify-content-between mt-3">
	@foreach($variation_mins as $group => $variation_mins_group)
	<div class="list-group list-group-accent flex-fill">
		<div class="list-group-item list-group-item-accent-primary list-group-item-primary">
			<div class="d-flex">
				#{{ $group }}
				<a href="#" class="btn btn-brand btn-danger ml-auto " data-toggle="modal" data-target="#clients_destroy_{{ $group }}"><i class="fa fa-trash"></i></a>
				@modal_destroy(['route_destroy' => 'variation_mins.destroy', 'model' => $group, 'modal_id' => 'clients_destroy_'.$group])
			</div>
		</div>
		@foreach($variation_mins_group as $group => $variation_min)
		<div class="list-group-item list-group-item-accent-secondary list-group-item-secondary">
			{{ $variation_min->variation->alias }}: <span class="font-weight-bold">{{ $variation_min->value }}</span><br>
			Mínimo: <span class="font-weight-bold">{{ $variation_min->min_qty }}</span>
		</div>
		@endforeach
	</div>
	@endforeach
</div>




@push('scripts')
<script>
	$(document).ready(function(){

		@foreach($variations as $variation)
		$('#{{ $variation->alias }}').prop('disabled', true);
		$('#{{ $variation->alias }}').hide();
		@endforeach

		$('#variations').change(function() {

			@foreach($variations as $variation)
			$('#no-varation-picked').hide();
			$('#{{ $variation->alias }}').prop('disabled', true);
			$('#{{ $variation->alias }}').hide();
			@endforeach

			let alias = $("#variations option:selected").text();
			
			if(this.value){
				$('#'+alias).prop('disabled', false);
				$('#'+alias).show();
			} else {
				$('#no-varation-picked').show();
			}

		});

	});

</script>
@endpush