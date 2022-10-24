@csrf
<div class="form-group inputwrapper">
    <label for="product_type">10% Merchantbay show at</label>
    <div class="input-list">
        <div>
            <input class="with-gap" name="config[ten_percent_show_at]" {{ ($configArray[0]=="frontend")? "checked" : "" }} type="radio" value="frontend" checked="" />
            <span>Frontend</span>
        </div>
        <div>
            <input class="with-gap" name="config[ten_percent_show_at]" {{ ($configArray[0]=="none")? "checked" : "" }} type="radio" value="none" />
            <span>None</span>
        </div>
    </div>
</div>
