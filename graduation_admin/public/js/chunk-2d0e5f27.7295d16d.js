(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0e5f27"],{"973f":function(t,e,a){"use strict";a.r(e);var r=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("el-breadcrumb",{attrs:{separator:"/",width:"100%"}},[a("el-breadcrumb-item",{attrs:{to:{path:"/"}}},[t._v("管理员管理")]),a("el-breadcrumb-item",[t._v("项目成员查看")])],1),a("el-divider"),a("el-table",{staticStyle:{width:"100%"},attrs:{data:t.tableData,"header-cell-style":{"text-align":"center"},"cell-style":{"text-align":"center"}}},[a("el-table-column",{attrs:{prop:"realname",label:"姓名",width:"200"}}),a("el-table-column",{attrs:{prop:"college",label:"所属学院",width:"200"}}),a("el-table-column",{attrs:{prop:"teachers_title",label:"职称",width:"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[1===e.row.teachers_title?a("el-button",{attrs:{type:"text"}},[t._v("助教")]):t._e(),2===e.row.teachers_title?a("el-button",{attrs:{type:"text"}},[t._v("讲师")]):t._e(),3===e.row.teachers_title?a("el-button",{attrs:{type:"text"}},[t._v("副教授")]):t._e(),4===e.row.teachers_title?a("el-button",{attrs:{type:"text"}},[t._v("教授")]):t._e()]}}])}),a("el-table-column",{attrs:{prop:"degree",label:"学位",width:"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[1===e.row.degree?a("el-button",{attrs:{type:"text"}},[t._v("学士")]):t._e(),2===e.row.degree?a("el-button",{attrs:{type:"text"}},[t._v("硕士")]):t._e(),3===e.row.degree?a("el-button",{attrs:{type:"text"}},[t._v("博士")]):t._e()]}}])}),a("el-table-column",{attrs:{prop:"phone",label:"联系电话",width:"200"}}),a("el-table-column",{attrs:{label:"操作",width:"200"},scopedSlots:t._u([{key:"default",fn:function(e){return[a("el-button",{attrs:{type:"text"},on:{click:function(a){return t.del(e.row.username)}}},[t._v("删除")])]}}])})],1)],1)},n=[],l={name:"ProjectMember",data:function(){return{tableData:[],id:"",length:0}},methods:{getData:function(){var t=this;this.$axios.get(this.$api.USER,{username_member:sessionStorage.getItem("username")}).then((function(e){200===e.data.code?t.tableData=e.data.data:t.$message.error(e.data.msg)}))},del:function(t){var e=this;this.$confirm("是否确认删除该用户","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then((function(){e.$axios.delete(e.$api.USER,{username:sessionStorage.getItem("username"),delusername:t}).then((function(t){200===t.data.code?(e.$message.success(t.data.msg),e.getData()):e.$message.error(t.data.msg)}))})).catch((function(){e.$message({type:"info",message:"已取消删除"})}))}},mounted:function(){this.getData()}},s=l,o=a("2877"),u=Object(o["a"])(s,r,n,!1,null,"a59f0e34",null);e["default"]=u.exports}}]);
//# sourceMappingURL=chunk-2d0e5f27.7295d16d.js.map