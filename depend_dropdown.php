<!-- HTML PART -->
<div class="form-group">
    <label>Polling Category<span class="text-danger">*</span>(If no Category <a href="{{route('polling_category.create')}}">Create Category</a> Here:)</label>
    <select name="polling_category_id" id="poll_cat" class="form-control">
        <option selected value>--Selece One--</option>
        @foreach ($category as $cat)
            <option value="{{$cat->id}}">{{$cat->category_name}}</option>
        @endforeach  
    </select>
    @error('polling_category_id')
        <span class="text-danger mt-1">{{ $message }}</span>
    @enderror
</div>

<div class="form-group">
    <label>Sub Category<span class="text-danger">*</span>(If no Category <a href="{{route('polling_sub_cat.create')}}">Create Category</a> Here:)</label>
    <select name="sub_category_id" class="form-control" id="sub_cat_dropdown">
        <option value>--Selece One--</option>
    </select>
    @error('sub_category_id')
        <span class="text-danger mt-1">{{ $message }}</span>
    @enderror
</div>

<!-- CONTROLLER PART -->
public function category_dropdown(Request $request)
{
    $show_sub_cat = "<option value>Select Sub Cat</option>";
    $sub_cat = PollingSubCategory::where('category_id', $request->cat_id)->get(['id','name']);
    foreach ($sub_cat as $cat) {
        // echo $cat->name .= "<option value='$cat->id'>$cat->name</option>";
        $show_sub_cat .= "<option value='$cat->id'>$cat->name</option>";
    }
    echo $show_sub_cat;
}

<!-- JQUERY PART -->
<script type="text/javascript">
    $(document).ready(function(){

        $('#poll_cat').change(function(){
        let cat_id = $(this).val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('category_dropdown') }}",
                type: "POST",
                data: {
                    cat_id : cat_id,
                },
                success: function(data){
                    $('#sub_cat_dropdown').html(data)
                },
            });
        });
    });
</script>
