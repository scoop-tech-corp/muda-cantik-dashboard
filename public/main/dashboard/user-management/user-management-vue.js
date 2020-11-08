const userApp = new Vue({
  el: '#user-app',
  data: {
    dataList: [],
    token: ''
  },
  mounted() {
    getAuthUser = JSON.parse(localStorage.getItem('muda-cantik'));
    this.token = getAuthUser.token;
    this.getDataList();
  },
  computed: {
  },
  methods: {
    getDataList: function() {
			axios.get(window.location.origin + '/api/admin/user/all', { 
          headers: { 
            "Content-Type": "application/json",
            'Authorization': `Bearer ${this.token}`
          }
        })
				.then(resp => {
          this.dataList = resp.data;
				})
				.catch(err => {
					console.log('error nich', err);
				});
		},
  },
});
