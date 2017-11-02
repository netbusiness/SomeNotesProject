<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SomeNotes</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="/css/user_dashboard.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/moment.min.js"></script>
  <script src="/js/user_dashboard.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <button type="button" id="newNoteButton" class="btn btn-default navbar-btn">New Note&nbsp;<span class="glyphicon glyphicon-plus"></span></button>
        <button type="button" id="logoutButton" class="btn btn-default navbar-btn pull-right">Logout</button>
      </div>
    </nav>
    <div class="main">
      <table id="noteList" class="table table-hover">
        <tbody></tbody>
        <!-- Cool stuff goes here -->
      </table>
    </div>
  </div>
  <div id="statusAlert" class="alert alert-success">Balls</div>
 <!-- New Note Modal -->
<div class="modal fade" id="newNoteModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel1">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel1">New Note</h4>
      </div>
      <div class="modal-body">
        <div id="newNoteModalAlert" class="alert alert-danger"></div>
        <input type="text" id="newNoteModalTitle" class="form-control" placeholder="Title">
        <textarea id="newNoteModalTextbody" class="form-control" rows="4" placeholder="Put your notes here!"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="newNoteModalSaveButton" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- Edit Note Modal -->
<div class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel2">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modalLabel2">Edit Note</h4>
      </div>
      <div class="modal-body">
        <div id="editNoteModalAlert" class="alert alert-danger"></div>
        <input type="text" id="editNoteModalTitle" class="form-control" placeholder="Title">
        <textarea id="editNoteModalTextbody" class="form-control" rows="4" placeholder="Put your notes here!"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" id="editNoteModalSaveButton" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>