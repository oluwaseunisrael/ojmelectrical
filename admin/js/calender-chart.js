JS
HTML
CSS
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
48
49
50
51
52
53
54
55
56
57
58
59
60
61
62
63
64
65
66
67
68
69
70
71
72
73
74
75
76
77
78
79
80
81
82
83
84
85
86
87
88
89
90
91
92
93
94
95
96
97
98
99
100
101
102
103
104
105
106
107
108
109
110
111
112
113
114
115
116
117
118
119
120
121
122
123
124
125
126
127
128
129
130
131
132
133
134
135
136
137
138
139
140
141
142
143
144
145
146
147
148
149
150
151
152
153
154
155
156
// JS 
var weekDays = [ 
  'Sun', 
  'Mon', 
  'Tue', 
  'Wed', 
  'Thu', 
  'Fri', 
  'Sat'
]; 
var palette1 = { 
  sport: '#039BE5', 
  meeting: '#43A047', 
  birthday: '#F4511E'
}; 
var dateRange = ['1/1/2023', '1/7/2023']; 
  
var data = [ 
  { 
    date: '1/2/2023 8:00', 
    event: 'Gym', 
    type: 'sport'
  }, 
  { 
    date: '1/2/2023 18:00', 
    event: 'Gym', 
    type: 'sport'
  }, 
  { 
    date: '1/4/2023 10:00', 
    event: 'Meeting Tyler', 
    type: 'meeting'
  }, 
  { 
    date: '1/5/2023 06:30', 
    event: 'Meeting  Sara', 
    type: 'meeting'
  }, 
  { 
    date: '1/5/2023 17:30', 
    event: 'Gym', 
    type: 'sport'
  }, 
  { 
    date: '1/6/2023 14:00', 
    event: 'Meeting Parents', 
    type: 'meeting'
  }, 
  { 
    date: '1/6/2023 16:00', 
    event: 'Birthday: Mom', 
    type: 'birthday'
  }, 
  { 
    date: '1/7/2023 10:30', 
    event: 'Tennis', 
    type: 'sport'
  } 
]; 
var chart = renderChart(data); 
renderHeader(); 
function renderChart(data) { 
  return JSC.chart('chartDiv1', { 
    debug: true, 
    type: 'horizontal calendar week solid', 
    legend_visible: false, 
    defaultAxis_defaultTick: { 
      label: { 
        color: '#BDBDBD', 
        style_fontSize: 10 
      }, 
      line_visible: false
    }, 
    yAxis_visible: false, 
    xAxis_scale_interval: 1, 
    defaultSeries: { 
      shape_innerPadding: 0, 
      mouseTracking_enabled: false, 
      defaultPoint: { 
        label: { 
          style_fontSize: 10, 
          text: '%event', 
          align: 'left'
        }, 
        attributes_event: ''
      } 
    }, 
    series: makeSeries(data) 
  }); 
  
  function makeSeries(data) { 
    return [ 
      { 
        points: data.map(function(item) { 
          var labelText = 
            '<span style="opacity:0.5">' + 
            JSC.formatDate(item.date, 't') + 
            '</span><br>' + 
            item.event; 
          return { 
            date: item.date, 
            attributes_event: [labelText], 
            color: [palette1[item.type], 0.5] 
          }; 
        }) 
      } 
    ]; 
  } 
} 
  
function renderHeader() { 
  // Create title div 
  var title = document.createElement('div'); 
  title.setAttribute('id', 'titleDiv'); 
  document 
    .getElementById('headerDiv') 
    .appendChild(title); 
  title.innerHTML = 'January 2023'; 
  // Create xAxis labels div 
  var ticks = document.createElement('div'); 
  ticks.setAttribute('id', 'ticksDiv'); 
  document 
    .getElementById('headerDiv') 
    .appendChild(ticks); 
  // Create all ticks divs 
  makeCustomTicks().forEach(function(item, i) { 
    var tick = document.createElement('div'); 
    tick.setAttribute('id', 'tickDiv' + i); 
    tick.setAttribute('class', 'ticks'); 
    document 
      .getElementById('ticksDiv') 
      .appendChild(tick); 
    tick.innerHTML = item; 
  }); 
  function makeCustomTicks() { 
    var ticks = []; 
    for ( 
      var i = new Date(dateRange[0]); 
      i <= new Date(dateRange[1]); 
      i.setDate(i.getDate() + 1) 
    ) { 
      ticks.push(new Date(i)); 
    } 
    ticks = ticks.map(function(v, i) { 
      return ( 
        weekDays[i] + 
        '<br>' + 
        '<span style="font-size:14px;font-weight:bold;">' + 
        JSC.formatDate(v, ' d') + 
        '</span><br>' + 
        JSC.formatDate(v, 'MMM') 
      ); 
    }); 
    return ticks; 
  } 
} 