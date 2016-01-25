(function () {
  var app = angular.module('note', []).config(function($interpolateProvider){
    $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
  });
  
  /**
   * Controlador del formulario
   */
  app.controller('FormNoteController', ['$scope', '$http', function ($scope, $http) {
      this.message = "";
      var note = this;
      
      this.save = function() {
        var message = new String(this.message);
        this.message = "";
        
        var newnote = {};
        newnote.message = message.valueOf();
        
        $scope.$broadcast('addNote', newnote);
        
        var data = $.param({
                'note' : newnote
            });
        
        var config = {
            headers : {
                'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
            }
        };
        
        var url = 'http://192.168.1.100/~francort/symfony_rest/web/app_dev.php/notes.json';
        
        $http.post(url, data, config)
        .success(function(data) {
            })
            .error(function(){
              alert("error on save");
              $scope.$broadcast('refreshList');
            });
        
        
       
      };
  }]);

  /**
   * Controlador del listado
   */
  app.controller('ListNoteController', ['$scope', '$http', function ($scope, $http) {
      this.notes = [];
      var listado = this;
      
      this.refreshNotes = function() {
          $http
            .get('http://192.168.1.100/~francort/symfony_rest/web/app_dev.php/notes.json')
            .success(function(data) {
              if(listado.notes !== data.notes){
                listado.notes = data.notes;
              }
            })
            .error(function(){
              alert("error");
            });
      };
      
      this.deleteNote = function(note) {
        var index = listado.notes.indexOf(note);
        listado.notes.splice(index, 1);
        
        var url = 'http://192.168.1.100/~francort/symfony_rest/web/app_dev.php/notes/'+note.id+'.json';

        var req = {
          method: 'delete',
          url: url
        };
        
        $http(req)
            .success(function() {
            })
            .error(function(){
              alert("error on delete");
              listado.refreshNotes();
            });
      };
      
      
      $scope.$on('refreshList', function (event, data) {
        listado.refreshNotes();
      });
      $scope.$on('addNote', function (event, data) {
        listado.notes.unshift(data);
        if(listado.notes.length > 10){
          listado.notes.pop();
        }
        
      });
      
      this.refreshNotes();
  }]);


})();


