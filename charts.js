// Animated progress chart using javascript
// Link: http://gionkunz.github.io/chartist-js/index.html


/*
var chart = new Chartist.Line('.ct-chart', {
  labels: [1, 2, 3],
  series: [
    [
      {meta: 'description', value: 1 },
      {meta: 'description', value: 5},
      {meta: 'description', value: 3}
    ]
  ]
}, {
  low: 0,
  high: 8,
  fullWidth: true,
  plugins: [
    Chartist.plugins.tooltip()
  ]
});
*/



var chart = new Chartist.Line('.ct-chart', {
  /*
  labels: ['Apr','--', '--', '--', 'Aug', 'Sep', '--','Nov','Dec','Jan'],

  // Apr = Executed First trade on the market 
  // Aug = Switched to Interactive Brokers
  // Sep = Started managing nearly 10k in assets for friends and family
  // Nov = Received wisdom from billionaire Peter Taunton, Constructed the idea of Algora Finance
  // Dec = First client pulled out with 16% gain after 4 months
  // Jan = Released website and social media accounts
  series: [
    [1,,,,2, 4,,7, 10, 16]
  ]
  */

  labels: ['Apr','--', '--', '--', 'Aug', 'Sep', '--','Nov','Dec','Jan'],
  series: [
    [
      {meta: 'description', value: 1},,,,
      {meta: 'description', value: 2},
      {meta: 'description', value: 4},,
      {meta: 'description', value: 7},
      {meta: 'description', value: 10},
      {meta: 'description', value: 16}
    ]
  ]
}, {
    low: 0,
    high: 24,
    divisor: 12,
    
    type: Chartist.FixedScaleAxis,
    plugins: [
      Chartist.plugins.tooltip()
    ]
});


// Let's put a sequence number aside so we can use it in the event callbacks
var seq = 0,
  delays = 80,
  durations = 500;

// Once the chart is fully created we reset the sequence
chart.on('created', function() {
  seq = 0;
});


// On each drawn element by Chartist we use the Chartist.Svg API to trigger SMIL animations
chart.on('draw', function(data) {
  seq++;

  if(data.type === 'line') {
    // If the drawn element is a line we do a simple opacity fade in. This could also be achieved using CSS3 animations.
    data.element.animate({
      opacity: {
        // The delay when we like to start the animation
        begin: seq * delays + 1000,
        // Duration of the animation
        dur: durations,
        // The value where the animation should start
        from: 0,
        // The value where it should end
        to: 1
      }
    });
  } else if(data.type === 'label' && data.axis === 'x') {
    data.element.animate({
      y: {
        begin: seq * delays,
        dur: durations,
        from: data.y + 100,
        to: data.y,
        // We can specify an easing function from Chartist.Svg.Easing
        easing: 'easeOutQuart'
      }
    });
  } else if(data.type === 'label' && data.axis === 'y') {
    data.element.animate({
      x: {
        begin: seq * delays,
        dur: durations,
        from: data.x - 100,
        to: data.x,
        easing: 'easeOutQuart'
      }
    });
  } else if(data.type === 'point') {
    data.element.animate({
      x1: {
        begin: seq * delays,
        dur: durations,
        from: data.x - 10,
        to: data.x,
        easing: 'easeOutQuart'
      },
      x2: {
        begin: seq * delays,
        dur: durations,
        from: data.x - 10,
        to: data.x,
        easing: 'easeOutQuart'
      },
      opacity: {
        begin: seq * delays,
        dur: durations,
        from: 0,
        to: 1,
        easing: 'easeOutQuart'
      }
    });
  } else if(data.type === 'grid') {
    // Using data.axis we get x or y which we can use to construct our animation definition objects
    var pos1Animation = {
      begin: seq * delays,
      dur: durations,
      from: data[data.axis.units.pos + '1'] - 30,
      to: data[data.axis.units.pos + '1'],
      easing: 'easeOutQuart'
    };

    var pos2Animation = {
      begin: seq * delays,
      dur: durations,
      from: data[data.axis.units.pos + '2'] - 100,
      to: data[data.axis.units.pos + '2'],
      easing: 'easeOutQuart'
    };

    var animations = {};
    animations[data.axis.units.pos + '1'] = pos1Animation;
    animations[data.axis.units.pos + '2'] = pos2Animation;
    animations['opacity'] = {
      begin: seq * delays,
      dur: durations,
      from: 0,
      to: 1,
      easing: 'easeOutQuart'
    };

    data.element.animate(animations);
  }
});


