<div id="master-container">
  <div id="form-container">
    <div class="container" id="tabs-container">

      <div class="left-col" id="toolbox-col" style="padding-top: 18px">

        <ul class="nav-tabs" role="tablist">
          <li class="active toolbox-tab" data-target="#add-field">Add a Field</li>
          <li class="toolbox-tab" data-target="#field-settings">Field Settings</li>
          <li class="toolbox-tab" data-target="#form-settings">Form Settings</li>
		  <li class="toolbox-tab hide " data-target="#form-advance">Advance</li>
        </ul>

        <div class="tab-content">

          <div class="tab-pane active" style="padding: 20px;" id="add-field">

            <div class="col-sm-12">
              <button class="button new-element" data-type="element-single-line-text" style="width: 50%;padding:5px;background:#ccc;">Single Line Text</button>
              <button class="button new-element" data-type="element-paragraph-text" style="width: 50%;padding:5px;background:#ccc;">Paragraph Text</button>
              <button class="button new-element" data-type="element-multiple-choice" style="width: 50%;padding:5px;background:#ccc;">Multiple Choice</button>
			  <button class="button grey new-element" data-type="element-section-break" style="width: 50%;padding:5px;background:#ccc;">Section Break</button>
			  
              
            </div>

            <div class="col-sm-12">
              <button class="button new-element" data-type="element-number" style="width: 50%;padding:5px;background:#ccc;">Number</button>
              <button class="button new-element" data-type="element-checkboxes" style="width: 50%;padding:5px;background:#ccc;">Checkboxes</button>
              <button class="button new-element" data-type="element-dropdown" style="width: 50%;padding:5px;background:#ccc;">Dropdown</button>
			  <button class="button new-element" data-type="element-file" style="width: 50%;padding:5px;background:#ccc;">File</button>
			  <button class="button new-element" data-type="element-date" style="width: 50%;padding:5px;background:#ccc;">Date</button>
			  <button class="button new-element" data-type="element-time" style="width: 50%;padding:5px;background:#ccc;">Time</button>
			  
			  
            </div>

            <div style="clear:both"></div>

            <!--
            <div class="col-sm-12">
              <hr/>
            </div>

            <div class="col-sm-6">
              <button class="button new-element" data-type="element-email" style="width: 100%;">Email</button>
            </div>
            -->

          </div>

          <div class="tab-pane" id="field-settings" style="padding: 20px; display: none; margin: none;">

            <div class="section">
              <div class="form-group">
                <label>Field Label</label>
                <input type="text" class="form-control" id="field-label" value="Untitled" />
              </div>
            </div>

            <div class="section" id="field-choices" style="display: none;">

              <div class="form-group">
                <label>Choices</label>
              </div>

            </div>

            <div class="section" id="field-options"> 

              <div class="form-group">
                <label>Field Options</label>
              </div>

              <div class="field-options">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" id="required">Required
                  </label>
                </div>
              </div>

            </div>

            <div class="section" id="field-description"> 
              
              <div class="form-group">
                <label>Field Description</label>
              </div>

              <div class="field-description">
                <textarea id="description"></textarea>
              </div>

            </div>

            <button class="buttont btn  danger btn-danger" id="control-remove-field">Remove</button>&nbsp;
            <button class="button btn btn-success" id="control-add-field">Add Field</button>

          </div>

          <div class="tab-pane" id="form-settings" style="padding: 20px; display: none">

            <div class="section row">
              <div class="form-group  ">
                <label>Title</label>
                <input type="text" class="bind-control form-control" data-bind="#form-title-label" id="form-title" value="" />
              </div>

              <div class="form-group   ">
                <label>Description</label>
                <textarea class="bind-control form-control" data-bind="#form-description-label" id="form-description"></textarea>
              </div>
			  
			  <div class="form-group  col-md-6 padding0">
                <label>Valid From</label>
                <input type="text" class="bind-control form-control datetimepicker" placeholder="Start Date" data-bind="#form-validfrom-label" id="form-validfrom"/>
              </div>
			  
			  
			  <div class="form-group col-md-6 padding0">
                <label>Valid Till</label>
                <input type="text" class="bind-control form-control datetimepicker" placeholder="End Date"  data-bind="#form-validtill-label" id="form-validtill"/>
              </div>
			  
			 <div class="form-group  col-md-6 padding0">
                <label>Form Background</label>
                <input type="color" class="bind-control form-control" data-bind="#form-background-label" id="form-backgroundcolor" value="#ffffff" />
              </div>
			  
			  <div class="form-group  col-md-6 padding0">
                <label>Submit Color</label>
                <input type="color" class="bind-control form-control" data-bind="#form-submit-label" id="form-submitcolor" value="#5cb85c" />
              </div>
			  
			  
            </div>

          </div>
		  
		  
		  
		  
		   <div class="tab-pane" id="form-advance" style="padding: 20px; display: none">

            <div class="section">
			
			  
			 <div class="form-group col-md-6">
                <label>Collect Payment</label>
                <input type="checkbox" class="bind-control form-control" data-bind="#form-payflag-label" id="form-payflag" value="1" />
              </div>
			  
			  
			  <div class="form-group col-md-6">
                <label>Form Price</label>
                <input type="text" class="bind-control form-control" data-bind="#form-payprice-label" id="form-payprice" value=""  required />
              </div>
			  
			  
			 <div class="form-group">
                <label>Generate Embed Code</label>
                <button class="btn btn-success" id="embed_generate" data-toggle="modal" data-target="#myModal" >Generate</button>
              </div>
			  


            </div>

          </div>
		  
		  
		  
		  

        </div>

      </div>

      <div class="right-col" id="form-col">

        <div class="loading">
          Loading...
        </div>

      </div>

      <div style="clear: both"></div>

    </div> <!-- /container -->
  </div>

  <div style="clear: both"></div>

</div>

<div style="clear: both"></div>