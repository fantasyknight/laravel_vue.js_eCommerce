// Cards
(function($) {

	$(function() {
		$('.card')
			.on( 'card:toggle', function() {
				var $this,
					direction;

				$this = $(this);
				direction = $this.hasClass( 'card-collapsed' ) ? 'Down' : 'Up';

				$this.find('.card-body, .card-footer')[ 'slide' + direction ]( 200, function() {
					$this[ (direction === 'Up' ? 'add' : 'remove') + 'Class' ]( 'card-collapsed' )
				});
			})
			.on( 'card:dismiss', function() {
				var $this = $(this);

				if ( !!( $this.parent('div').attr('class') || '' ).match( /col-(xs|sm|md|lg)/g ) && $this.siblings().length === 0 ) {
					$row = $this.closest('.row');
					$this.parent('div').remove();
					if ( $row.children().length === 0 ) {
						$row.remove();
					}
				} else {
					$this.remove();
				}
			})
			.on( 'click', '[data-card-toggle]', function( e ) {
				e.preventDefault();
				$(this).closest('.card').trigger( 'card:toggle' );
			})
			.on( 'click', '[data-card-dismiss]', function( e ) {
				e.preventDefault();
				$(this).closest('.card').trigger( 'card:dismiss' );
			})
			/* Deprecated */
			.on( 'click', '.card-actions a.fa-caret-up', function( e ) {
				e.preventDefault();
				var $this = $( this );

				$this
					.removeClass( 'fa-caret-up' )
					.addClass( 'fa-caret-down' );

				$this.closest('.card').trigger( 'card:toggle' );
			})
			.on( 'click', '.card-actions a.fa-caret-down', function( e ) {
				e.preventDefault();
				var $this = $( this );

				$this
					.removeClass( 'fa-caret-down' )
					.addClass( 'fa-caret-up' );

				$this.closest('.card').trigger( 'card:toggle' );
			})
			.on( 'click', '.card-actions a.fa-times', function( e ) {
				e.preventDefault();
				var $this = $( this );

				$this.closest('.card').trigger( 'card:dismiss' );
			});
	});

})(jQuery);