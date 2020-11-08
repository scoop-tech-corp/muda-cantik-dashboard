// Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('value');

const masterApp = new Vue({
	el: '#master-app',
	data: {
    fullname: '',
    username: '',
    role: '',
    token: '',
    message: '',
    showAlert: false,
    isSuccess: false,
    baseUrl: ''
  },
  mounted() {
    let getAuthUser = localStorage.getItem('muda-cantik');
    if (!getAuthUser) {
      alert('You Must Login First!');
      location.href = this.$refs.baseUrl.value + '/admin/login';
    } else {
      getAuthUser = JSON.parse(getAuthUser);
      this.fullname = getAuthUser.fullName;
      this.username = getAuthUser.username;
      this.token = getAuthUser.token;
      this.role = getAuthUser.role === 'superadmin' ? 'Super Admin' : getAuthUser.role;
    }
  },
  methods: {
    onSignOut: function() {
      const formData = { 'username': this.username };
      axios.post(this.$refs.baseUrl.value + '/api/admin/auth/signout', formData, { 
        headers: { 
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${this.token}`
       },
      })
      .then(resp => {
        localStorage.removeItem('muda-cantik');
        location.href = this.$refs.baseUrl.value + '/admin/login';
      })
      .catch(err => {
        console.log('error nich', err);
      })
      .finally(() => {
        // setTimeout(() => {
        //   this.showAlert = false;
        //   if (this.isSuccess) { location.href = this.$refs.baseUrl.value + '/admin'; }
        // }, 2000);
      });
    }
  }
});
