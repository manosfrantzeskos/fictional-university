import $ from 'jquery';

class MyNotes {

  constructor() {
    this.events();
  }


  events() {
    $('#myNotes').on('click', '.delete-note', this.deleteNote);
    $('#myNotes').on('click', '.edit-note', this.editNote.bind(this));
    $('#myNotes').on('click', '.update-note', this.updateNote.bind(this));
    $('.submit-note').on('click', this.createNote.bind(this));
  }


  editNote(event) {
    const theNote = $(event.target).parents('li');

    theNote.data('state') === 'editable' ? this.makeNoteReadOnly(theNote) : this.makeNoteEditable(theNote);
  }


  makeNoteEditable(theNote) {
    theNote.find('.edit-note').html('<i class="fa fa-times" aria-hidden="true"></i> Cancel')
    theNote.find('.note-title-field, .note-body-field').removeAttr('readonly').addClass('note-active-field');
    theNote.find('.update-note').addClass('update-note--visible');
    theNote.data('state', 'editable');
  }


  makeNoteReadOnly(theNote) {
    theNote.find('.edit-note').html('<i class="fa fa-pencil" aria-hidden="true"></i> Edit')
    theNote.find('.note-title-field, .note-body-field').attr('readonly', 'readonly').removeClass('note-active-field');
    theNote.find('.update-note').removeClass('update-note--visible');
    theNote.data('state', 'cancel');
  }


  createNote(event) {
    const newPostData = {
      'title': $('.new-note-title').val(),
      'content': $('.new-note-body').val(),
      'status': 'private'
    };

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.siteUrl + '/wp-json/wp/v2/note',
      type: 'POST',
      data: newPostData,
      success: (response) => {
        $('.new-note-title, .new-note-body').val('');
        $(`
          <li data-id="${response.id}">
            <input class="note-title-field" value="${response.title.raw}" readonly>
            <span class="edit-note">
              <i class="fa fa-pencil" aria-hidden="true"></i> Edit
            </span>
            <span class="delete-note">
              <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
            </span>
            <textarea class="note-body-field" readonly>${response.content.raw}</textarea>
            <span class="update-note btn btn--blue btn--small">
              <i class="fa fa-arrow-right" aria-hidden="true"></i> Save
            </span>
          </li>
        `).prependTo('#myNotes').hide().slideDown();
        console.log('Success');
        console.log(response);
      },
      error: (response) => {
        if (response.responseText === 'Note limit reached') {
          $('.note-limit-message').addClass('active');
        }
        console.log('Error');
        console.log(response);
      }
    });
  }


  updateNote(event) {
    const theNote = $(event.target).parents('li');
    const updatedPostData = {
      'title': theNote.find('.note-title-field').val(),
      'content': theNote.find('.note-body-field').val()
    };

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.siteUrl + '/wp-json/wp/v2/note/' + theNote.data('id'),
      type: 'POST',
      data: updatedPostData,
      success: (response) => {
        this.makeNoteReadOnly(theNote);
        console.log('Success');
        console.log(response);
      },
      error: (response) => {
        console.log('Error');
        console.log(response);
      }
    });
  }


  deleteNote(event) {
    const theNote = $(event.target).parents('li');

    $.ajax({
      beforeSend: (xhr) => {
        xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
      },
      url: universityData.siteUrl + '/wp-json/wp/v2/note/' + theNote.data('id'),
      type: 'DELETE',
      success: (response) => {
        theNote.slideUp();
        if (response.note_count < 5) {
          $('.note-limit-message').removeClass('active');
        }
        console.log('Success');
        console.log(response);
      },
      error: (response) => {
        console.log('Error');
        console.log(response);
      }
    });
  }

}

export default MyNotes;
