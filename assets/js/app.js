'use strict';

(function(){
	jQuery.ajax({
		url: famtree_vars.baseurl,
		type: 'GET',
		success: function(res){
			console.log(res)
			renderData(res)
		}
	})

	function renderData(data){

		var svg = d3.select('#famtree-canvas').append('svg')
			.attr('width', '90%').attr('height', 600)
			.call(d3.zoom().on("zoom", function () {
			    svg.attr("transform", d3.event.transform)
			 }))
			.append('g').attr('transform', 'translate(100,100)')

		var dataStructure = d3.stratify()
			.id(function(d){ return d.id })
			.parentId(function(d){ return d.parent })
			(data)
		var treeStructure = d3.tree().size([650, 300])
		var information = treeStructure(dataStructure)


		var connections = svg.append('g').selectAll('path')
			.data(information.links())

		connections.enter().append('path')
			.attr('d', function(d){
				return 'M' + d.source.x + ',' + d.source.y + ' C ' +
				d.source.x + ',' + (d.source.y + d.target.y)/2 + ' '  +
				d.target.x + ',' + (d.source.y + d.target.y)/2 +  ' ' +
				d.target.x + ',' + d.target.y

			})

		var rectangles = svg.append('g').selectAll('rect')
						 .data(information.descendants())
		rectangles.enter().append('rect')
			.attr('x', function(d){return d.x-60})
			.attr('y', function(d){return d.y-20})
			.attr('r', 10)
			.on('click', function(d){
				jQuery('#node-details').addClass('show')
				jQuery('#data').html(d.data.name)
			})

		var names = svg.append('g').selectAll('text')
			.data(information.descendants())

		names.enter().append('text')
			.text(function(d){return d.data.name})
			.attr('x', function(d){return d.x})
			.attr('y', function(d){return d.y})
			.classed('bigger', true)


		var images = svg.append('g').selectAll('image')
						.data(information.descendants())
		images.enter().append('svg:image')
			.attr('xlink:href', function(d){return d.data.image[0]})
			.attr('x', function(d){
				if(d.data.image.length > 1){
					return d.x-45
				} else {
					return d.x-15
				}
			})
			.attr('y', function(d){return d.y-60})
			.attr('width', 30)
			.attr('height', 30)
			.classed('img-profile', true)
		var images2 = svg.append('g').selectAll('image')
			.data(information.descendants())
		images2.enter().append('svg:image')
			.attr('xlink:href', function(d){return d.data.image[1]})
			.attr('x', function(d){
				if(d.data.image.length > 1){
					return d.x+15
				} else {
					return d.x
				}
			})
			.attr('y', function(d){return d.y-60})
			.attr('width', 30)
			.attr('height', 30)
			.classed('img-profile', true)
		jQuery('#close').on('click', function(){
			jQuery('#node-details').removeClass('show')
			jQuery('#data').html()
		})
	}
})()