@extends('layout')
@section('main')

<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
    <div id="main" class="col-md-12" style="height:300px;">
      
    </div>
    <script type="text/javascript">
      // 基于准备好的dom，初始化echarts实例
      var myChart = echarts.init(document.getElementById('main'));
      var option = {
          title: {
              text: '最近订单量'
          },
          tooltip: {
              trigger: 'axis'
          },
          legend: {
              data:['好评单','中评单','差评单','已完成','未完成','未处理']
          },
          grid: {
              left: '3%',
              right: '4%',
              bottom: '3%',
              containLabel: true
          },
          toolbox: {
              feature: {
                  saveAsImage: {}
              }
          },
          xAxis: {
              type: 'category',
              boundaryGap: false,
              data: ['周一','周二','周三','周四','周五','周六','周日']
          },
          yAxis: {
              type: 'value'
          },
          series: [
              {
                  name:'好评单',
                  type:'line',
                  stack: '总量',
                  data:[12,15,17,10,20,5,6]
              },
             {
                name:'中评单',
                type:'line',
                stack: '总量',
                data:[22, 18, 19, 23, 29, 33, 31]
            },
            {
                name:'差评单',
                type:'line',
                stack: '总量',
                data:[15, 23, 20, 15, 19, 33, 41]
            },
            {
                name:'已完成',
                type:'line',
                stack: '总量',
                data:[32, 33, 30, 33, 39, 33, 32]
            },
            {
                name:'未完成',
                type:'line',
                stack: '总量',
                data:[82, 93, 90, 93, 12, 13, 13]
            },
            {
                name:'未处理',
                type:'line',
                stack: '总量',
                data:[20, 32, 19, 34, 12,30, 29]
            }
          ]
      };
      // 使用刚指定的配置项和数据显示图表。
        myChart.setOption(option);

    </script>

@stop 