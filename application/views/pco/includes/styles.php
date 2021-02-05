<style>
  /* input.error, input.error:focus {
    border-color: rgba(235, 23, 23, 0.8) !important;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(235, 23, 23, 0.6) !important;
    outline: 0 none !important;
  } */
  table {
    word-wrap: break-word;
  }
  table th {
    text-align: center;
  }
  .modal-lg {
    min-width: 70% !important;
  }
  .set_error {
    font-size: 13px;
    color: red;
  }
  .set_note {
    font-size: 13px;
    color: blue;
  }
  textarea {
    min-height: 120px;
  }
  .data-div {
    min-height: 870px;
  }
  .upload_div {
    border: 1px solid #EAECF4;
  }
  .upload_div a {
    font-size: 13px !important;
    padding: 5px;
    margin: 5px;
  }
  .card-body {
    font-size: 13px;
  }
  .modal-body {
    font-size: 14px;
  }
  /* .container{
    margin: 0 auto;
    width: 100px;
  } */
  .error {
    font-size: 12px !important;
  }
  div.viewTransactionModal div.modal-content {
    min-height: 895px;
  }
  .multitrans-div {
    /* width: 100%; */
    color:#FFF;
    background-color:#535F6F;
  }

  /* db_loader */
  #inbox_table_processing {
    border: 0;
    background-color: transparent;
  }

  /* pco steps styles */
  .active_step, .active_step ul a {
    border-color: rgba(126, 239, 104, 0.8);
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.075), inset 0 0 2px blue, inset 0 0 5px darkblue;
    outline: 0 none;
    background-color:#fafafa;
  }
  .active_step p a {
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.075), 0 0 25px blue, 0 0 5px darkblue;
  }

  #radioBtn .notActive {
    color: #3276b1;
    background-color: #fff;
  }
  /* social-network changed to stephead-list */
  ul.stephead-list {
    list-style: none;
    display: inline;
    margin-left:0 !important;
    padding: 0;
  }
  ul.stephead-list li {
    display: inline;
    margin: 0 5px;
  }
  ul.stephead-list p {
    color: #550DAB;
    font-size: 15px;
  }

  .social-network a.iconPlus:hover {
    background-color: #F56505;
  }
  .social-network a.iconPlus:hover i {
    color:#fff;
  }
  .social-network a.iconAdd:hover {
    background-color: #2FA3B4;
  }
  .social-network a.iconAdd:hover i {
    color:#fff;
  }
  /* social-circle changed to stephead-circle */
  .stephead-circle li a {
    display:inline-block;
    position:relative;
    margin:0 auto 0 auto;
    -moz-border-radius:50%;
    -webkit-border-radius:50%;
    border-radius:50%;
    text-align:center;
    width: 50px;
    height: 50px;
    font-size:20px;
  }
  .stephead-circle li i {
    margin:0;
    line-height:50px;
    text-align: center;
  }
  .stephead-circle li a:hover i, .triggeredHover {
    -moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -ms--transform: rotate(360deg);
    transform: rotate(360deg);
    -webkit-transition: all 0.2s;
    -moz-transition: all 0.2s;
    -o-transition: all 0.2s;
    -ms-transition: all 0.2s;
    transition: all 0.2s;
  }
  .stephead-circle i {
    color: #fff;
    -webkit-transition: all 0.8s;
    -moz-transition: all 0.8s;
    -o-transition: all 0.8s;
    -ms-transition: all 0.8s;
    transition: all 0.8s;
  }

  .iconPlus {
   background-color: #D3D3D3;
  }
  .iconAdd {
   background-color: #D3D3D3;
  }
  .iconStepper {
   background-image: linear-gradient(#2D80CF, #AF7AD0);
  }

  .btn-glow:hover {
    box-shadow: 1px 1px 12px #2D80CF;
  }
  /* .selected {
    color:#444;
    border:1px solid #CCC;
    background:#97B9F2;
    box-shadow: 0 0 5px -1px rgba(0,0,0,0.2);
    cursor:pointer;
  } */
  .disabledContent {
    cursor: not-allowed;
    background-color: rgb(229, 229, 229) !important;
  }
  .disabledContent > * {
      pointer-events:none;
  }
  .smlab {
    font-size: 14px !important;
  }
  label {
    color: black;
  }
  label > span, th > span {
    color: red;
  }
  .justify-content-center {
    text-align: center;
  }
  .reqfields {
    font-size: 13px;
    color: red;
  }

  /* dropzone */
  div.dropzone_table {
    display: table;
    white-space: nowrap;
  }
  div.dropzone_table .file-row {
    display: table-row;
  }
  div.dropzone_table .file-row > div {
    display: table-cell;
    vertical-align: top;
  }
  div.dropzone_table .file-row:nth-child(odd) {
    background: #f9f9f9;
  }

  /* The total progress gets shown by event listeners */
  #total-progress {
    opacity: 0;
    transition: opacity 0.3s linear;
  }
  /* Hide the progress bar when finished */
  #previews .file-row.dz-success .progress {
    opacity: 0;
    transition: opacity 0.3s linear;
  }
  /* Hide the delete button initially */
  #previews .file-row .delete {
    display: none;
  }
  /* Hide the start and cancel buttons and show the delete button */
  #previews .file-row.dz-success .start,
  #previews .file-row.dz-success .cancel {
    display: none;
  }
  #previews .file-row.dz-success .delete {
    display: block;
  }

  #view_attachments{
    padding: 2px 7px 2px 7px;
    color: #000;

  }

</style>
