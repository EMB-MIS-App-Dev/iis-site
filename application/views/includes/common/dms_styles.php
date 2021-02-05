<style>
  .asgn-on-leave {
    color: red !important;
  }
  td.bold{
    font-weight: bold;
  }
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
  .container{
    margin: 0 auto;
    width: 100px;
  }
  .error {
    font-size: 12px !important;
  }

  /* multiprc css */
  div.viewTransactionModal div.modal-content {
    min-height: 895px;
  }

  .multitrans-div {
    /* width: 100%; */
    color:#FFF;
    background-color:#535F6F;
  }

  .user-multi-history {
    color: rgba(255, 255, 255, 1);
    box-shadow: 0 5px 15px rgba(145, 92, 182, .4);
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.075), inset 0 0 2px blue, inset 0 0 5px darkorange;

    outline: 0 none;
    background-color:#fafafa;
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.075), 0 0 25px blue, 0 0 5px darkorange;
  }

  .user-multi-history .multi-name {
    color: black !important;
  }

  /* db_loader */
  #inbox_table_processing {
    border: 0;
    background-color: transparent;
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
