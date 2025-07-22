<form onsubmit="moveToNewFolder(event)">
  <select name="destination" class="form-control">
    @foreach($root_folders as $root_folder)
      <option value="{{ $root_folder->url }}">{{ $root_folder->name }}</option>
      @foreach($root_folder->children as $directory)
        <option value="{{ $directory->url }}">
          {{ str_repeat("\u{00A0}", $directory->depth*3) }}{{ $directory->name }}
          @if($directory->parent)
            ({{ $directory->parent }})
          @endif
        </option>
      @endforeach
    @endforeach
  </select>
  <button class="btn my-1 btn-primary w-100"
    type="submit">{{ __('laravel-filemanager::lfm.btn-confirm') }}</button>
</form>

<script>
  function moveToNewFolder(e) {
    e.preventDefault();
    const data = new FormData(e.target);    
    performLfmRequest('domove', {
      items: @json($items),
      goToFolder: data.get('destination'),
    }).done(
      function(data){
        $("#notify").modal('hide');
        refreshFoldersAndItems(data);
      }      
    );
  }
</script>