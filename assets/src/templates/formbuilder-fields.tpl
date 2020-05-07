<ul id="form-elements" style="display: none">

      {#form}
      <li class="form-element" id="form-settings-element" data-type="form-settings">
        <h2 id="form-title-label">{title}</h2>
        <h3 id="form-description-label">{description}</h5>
      </li>

      <li>
        <ul id="sortable-elements">

          {#fields}

            <!-- Single Line Text -->

            {@eq key="{type}" value="element-single-line-text"} 


              <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-single-line-text">
                <label>
                  <span class="label-title">{title}</span>
                  {#required}<span class="required-star"> *</span>{/required}
                </label>
                <input type="text" class="form-control" value="" disabled />
              </li>

            {/eq}
			
			
			
		 <!-- File -->

            {@eq key="{type}" value="element-file"} 


              <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-file">
                <label>
                  <span class="label-title">{title}</span>
                  {#required}<span class="required-star"> *</span>{/required}
                </label>
                <input type="file" class="form-control" value="" disabled />
              </li>

            {/eq}
			
			
			
			
			
			
			<!-- Date -->

            {@eq key="{type}" value="element-date"} 


              <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-date">
                <label>
                  <span class="label-title">{title}</span>
                  {#required}<span class="required-star"> *</span>{/required}
                </label>
                <input type="date" class="form-control" value="" disabled />
              </li>

            {/eq}
			
			
			<!-- Time -->

            {@eq key="{type}" value="element-time"} 


              <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-time">
                <label>
                  <span class="label-title">{title}</span>
                  {#required}<span class="required-star"> *</span>{/required}
                </label>
                <input type="time" class="form-control" value="" disabled />
              </li>

            {/eq}


            <!-- Number -->

            {@eq key="{type}" value="element-number"} 

              <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-number">
                <label>
                  <span class="label-title">{title}</span>
                  {#required}<span class="required-star"> *</span>{/required}
                </label>
                <input type="number" class="form-control" value="" disabled />
              </li>

            {/eq}

            <!-- Paragraph Text -->

            {@eq key="{type}" value="element-paragraph-text"} 

            <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-paragraph-text">
              <label>
                <span class="label-title">{title}</span>
                {#required}<span class="required-star"> *</span>{/required}
              </label>
              <textarea disabled></textarea>
            </li>

            {/eq}

            <!-- Multiple-Choice -->

            {@eq key="{type}" value="element-multiple-choice"}

              <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-multiple-choice">

                <label>
                  <span class="label-title">{title}</span>
                  {#required}<span class="required-star"> *</span>{/required}
                </label>

                <div class="choices" data-type="settings-choice-radio">

                  {#choices}

                    <div class="choice radio disabled">
                      <label>
                        <input type="radio" class="option-{@idx}{.}{/idx}" name="element-{position}-choice" value="{value}" {#checked}checked{/checked} disabled>
                        <span class="choice-label">{title}</span>
                      </label>
                    </div>

                  {/choices}

                </div>

              </li>

            {/eq}

            <!-- Dropdown -->

            {@eq key="{type}" value="element-dropdown"}

              <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-dropdown">
                <label>
                  <span class="label-title">{title}</span>
                  {#required}<span class="required-star"> *</span>{/required}
                </label>
                <select style="width: 50%" class="choices" data-type="settings-dropdown" disabled>

                  {#choices}

                    <option class="option-{@idx}{.}{/idx}" value="{value}" {#checked}selected{/checked}><span class="choice-label">{title}</span></option>

                  {/choices}

                </select>
              </li>

            {/eq}

            <!-- Checkboxes -->

            {@eq key="{type}" value="element-checkboxes"}

              <li class="form-element {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-type="element-checkboxes">

                <label>
                  <span class="label-title">{title}</span>
                  {#required}<span class="required-star"> *</span>{/required}
                </label>

                <div class="choices" data-type="settings-choice-checkbox">

                  {#choices}

                  <div class="choice checkbox disabled">
                    <label>
                      <input type="checkbox" class="option-{@idx}{.}{/idx}" {#checked}checked{/checked} name="element-{position}-choice" value="{value}" disabled>
                      <span class="choice-label">{title}</span>
                    </label>
                  </div>

                  {/choices}
                  
                </div>

              </li>

            {/eq}

            <!-- Section Break -->

            {@eq key="{type}" value="element-section-break"}

              <li class="form-element section-break {#required}required{/required}" id="element-{position}" data-label="{title}" data-position="{position}" data-description="{description}" data-type="element-section-break">
                <hr/>
                <label class="label-title"><span class="label-title">{title}</label>
                <p class="description">{description}</p>
              </li>

            {/eq}

          {/fields}

        </ul>

      </li>

      {/form}

    </ul>
<center>
    <button id="save" class="button success" style="padding:1.2em;" >Save Form</button>
	<a id="preview" href="#" target="_blank" class="button btn-info"  style="border:0;background:#10c6c6;padding:1em;">Preview Form</a>
</center>