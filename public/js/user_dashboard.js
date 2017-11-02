$(function() {
  $("#newNoteButton").on("click", function(event) {
    $("#newNoteModalAlert").hide();
    $("#newNoteModalTitle").val("");
    $("#newNoteModalTextbody").val("");
    $("#newNoteModal").modal("show");
  });
  
  $("#newNoteModalSaveButton").on("click", notes_M.saveNewNote);
  $("#editNoteModalSaveButton").on("click", notes_M.updateNote);
  
  // Keep from rebinding
  $("#noteList").on("click", ".glyphicon-remove", function(event) {
    event.stopPropagation();
    var yesNo = confirm("Are you sure you want to delete this note?");
    if (yesNo) {
      var noteID = $(event.target).closest("td.note-list-row").data("id");
      notes_M.deleteNote(noteID);
      // notes_M.getNotes();
    }
  });
  
  $("#noteList").on("click", "td.note-list-row", function(event) {
    var note = notes_M.getNoteByID($(event.currentTarget).data("id"));
    
    notes_V.showNote(note);
  });
  
  $("#logoutButton").on("click", function(event) {
    window.location = "/logout";
  });
  
  document.addEventListener("updateView", notes_V.drawNotesList, false);
  
  notes_M.getNotes();
});

(function() {
  window.notes_M = {};
  
  notes_M.notes = [];
  notes_M.getNotes = function() {
    $.ajax({
      url: "/notes",
      type: "GET",
      dataType: "json"
    }).done((data) => {
      this.notes = data;
      var evt = new CustomEvent("updateView");
      document.dispatchEvent(evt);
    });
  };
  notes_M.getNoteByID = function(noteID) {
    for (var i in this.notes) {
      if (this.notes[i].id == noteID) {
        return this.notes[i];
      }
    }
    
    return null;
  };
  notes_M.saveNewNote = function(event) {
    var noteTitle = $("#newNoteModalTitle").val();
    var noteContent = $("#newNoteModalTextbody").val();
    $.post("/notes", {
      title: noteTitle,
      content: noteContent
    }).done(function(data) {
      if (typeof data.success !== "undefined") {
        notes_M.getNotes();
        $("#newNoteModal").modal("hide");
      }
    }).fail(function(response) {
      var data = response.responseJSON;
      $("#newNoteModalAlert").html("");
      for (var key in data) {
        $("#newNoteModalAlert").append("<p>" + data[key] + "</p>");
      }
      $("#newNoteModalAlert").show();
    });
  };
  notes_M.updateNote = function(event) {
    var note = notes_M.getNoteByID(notes_V.currentlyDisplayedNoteID);
    note.title = $("#editNoteModalTitle").val();
    note.content = $("#editNoteModalTextbody").val();
    
    $.ajax({
      url: "/notes/" + note.id,
      type: "PUT",
      dataType: "json",
      data: {title: note.title, content: note.content}
    }).done(function(data) {
      $("#editNoteModal").modal("hide");
      $("#statusAlert").html("Note edited successfully").removeClass("alert-danger").addClass("alert-success").show();
      window.setTimeout(function() {
        $("#statusAlert").hide(500);
      }, 4000);
      notes_M.getNotes();
    }).fail(function(response) {
      var data = response.responseJSON;
      $("#editNoteModalAlert").html("");
      for (var key in data) {
        $("#editNoteModalAlert").append("<p>" + data[key] + "</p>");
      }
      $("#editNoteModalAlert").show();
    });
  };
  notes_M.deleteNote = function(noteID) {
    $.ajax({
      url: "/notes/" + noteID,
      type: "DELETE",
      dataType: "json"
    }).done((data) => {
      $("#statusAlert").html("Note deleted successfully").removeClass("alert-danger").addClass("alert-success").show();
      window.setTimeout(function() {
        $("#statusAlert").hide(500);
      }, 4000);
      this.getNotes();
    }).fail((response) => {
      var data = response.responseJSON;
      $("#statusAlert").html("");
      for (var key in data) {
        $("#statusAlert").append("<p>" + data[key] + "</p>");
      }
      $("#statusAlert").removeClass("alert-success").addClass("alert-danger").show();
      window.setTimeout(function() {
        $("#statusAlert").hide(500);
      }, 4000);
    });
  };
  
  window.notes_V = {};
  notes_V.currentlyDisplayedNoteID = null;
  notes_V.drawNotesList = function() {
    $("#noteList tbody").html("");
    for (var i in notes_M.notes) {
      var lastUpdated = moment(notes_M.notes[i].updated_at, "YYYY-MM-DD HH:mm:ss");
      var myHTML = '<tr><td class="note-list-row" data-id="' + notes_M.notes[i].id + '">';
      // myHTML += '<a href="javascript://"><span class="glyphicon glyphicon-pencil"></span></a>';
      myHTML += '<span class="last-edit-time">(Last edited by ' + notes_M.notes[i].owner.name + ', ' + lastUpdated.format("ddd h:mm A") + ')</span>';
      myHTML += '<a href="javascript://"><span class="glyphicon glyphicon-remove"></span></a>';
      myHTML += '<div class="note-title">' + notes_M.notes[i].title + '</div>';
      myHTML += '</td></tr>';
      
      $("#noteList tbody").append(myHTML);
    }
  };
  notes_V.showNote = function(note) {
    this.currentlyDisplayedNoteID = note.id;
    $("#editNoteModalAlert").hide();
    $("#editNoteModalTitle").val(note.title);
    $("#editNoteModalTextbody").val(note.content);
    $("#editNoteModal").modal("show");
  };
})();