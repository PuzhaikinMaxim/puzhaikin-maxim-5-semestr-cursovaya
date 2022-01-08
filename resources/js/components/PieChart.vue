<script>
import { Pie} from 'vue-chartjs'

export default {
  extends: Pie,
  props: ['chartdata', 'options'],
  mounted () {
    this.renderChart(this.chartdata, this.options)
  },
  methods : {
    updateChart(chartdataset){
      this.renderChart(chartdataset, this.options);
    }
  }
}
</script>