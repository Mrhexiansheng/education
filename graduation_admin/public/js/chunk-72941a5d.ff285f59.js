(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-72941a5d"],{6762:function(e,t,a){"use strict";var r=a("5ca1"),s=a("c366")(!0);r(r.P,"Array",{includes:function(e){return s(this,e,arguments.length>1?arguments[1]:void 0)}}),a("9c6c")("includes")},"82bd":function(e,t,a){"use strict";a.r(t);var r=function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",[a("el-breadcrumb",{attrs:{separator:"/",width:"100%"}},[a("el-breadcrumb-item",{attrs:{to:{path:"/"}}},[e._v("管理员管理")]),a("el-breadcrumb-item",[e._v("项目申请")])],1),a("el-divider"),a("el-tabs",{model:{value:e.activeName,callback:function(t){e.activeName=t},expression:"activeName"}},[a("el-tab-pane",{attrs:{label:"申请项目",name:"first"}},[a("el-row",[a("el-col",{attrs:{span:8}},[a("el-form",{ref:"applyForm",attrs:{"label-width":"100px",model:e.form,rules:e.rules,"hide-required-asterisk":!0,"status-icon":!0}},[a("el-form-item",{attrs:{label:"项目申报人",prop:"realname"}},[a("el-input",{attrs:{placeholder:"请输入项目申报人",disabled:""},model:{value:e.form.realname,callback:function(t){e.$set(e.form,"realname",t)},expression:"form.realname"}})],1),a("el-form-item",{attrs:{label:"项目名称",prop:"name"}},[a("el-input",{attrs:{placeholder:"请输入项目名称"},model:{value:e.form.name,callback:function(t){e.$set(e.form,"name",t)},expression:"form.name"}})],1),a("el-form-item",{attrs:{label:"项目简介",prop:"description"}},[a("el-input",{attrs:{placeholder:"请输入项目简介",type:"textarea",rows:2},model:{value:e.form.description,callback:function(t){e.$set(e.form,"description",t)},expression:"form.description"}})],1),a("el-form-item",{attrs:{label:"项目关键词",prop:"keywords"}},[a("el-input",{attrs:{placeholder:"请输入项目关键词"},model:{value:e.form.keywords,callback:function(t){e.$set(e.form,"keywords",t)},expression:"form.keywords"}})],1),a("el-form-item",{attrs:{label:"项目类型",prop:"level"}},[a("el-select",{attrs:{placeholder:"请选择"},model:{value:e.form.level,callback:function(t){e.$set(e.form,"level",t)},expression:"form.level"}},e._l(e.options,(function(e){return a("el-option",{key:e.value,attrs:{label:e.label,value:e.value}})})),1)],1),a("el-form-item",{attrs:{label:"项目类别",prop:"type"}},[a("el-select",{attrs:{placeholder:"请选择"},model:{value:e.form.type,callback:function(t){e.$set(e.form,"type",t)},expression:"form.type"}},e._l(e.options1,(function(e){return a("el-option",{key:e.id,attrs:{label:e.type,value:e.id}})})),1)],1),a("el-form-item",{attrs:{label:"项目文件",prop:"file"}},[a("el-upload",{staticClass:"upload-demo",attrs:{action:e.uploadFile,"on-remove":e.handleRemove1,"before-upload":e.beforeFileUpload,"on-success":e.handleFileSuccess,"file-list":e.form.file}},[a("el-button",[e._v("点击上传")])],1)],1),a("el-form-item",{attrs:{label:"项目相关图片",prop:"thumb"}},[a("el-upload",{staticClass:"upload-demo",attrs:{action:e.upload,"on-remove":e.handleRemove,"on-success":e.handleAvatarSuccess1,"before-upload":e.beforePhoneUpload,"file-list":e.form.thumb,"list-type":"picture"}},[a("el-button",[e._v("点击上传")])],1)],1),a("el-form-item",[a("el-button",{staticStyle:{width:"80%"},on:{click:e.apply}},[e._v("提交")])],1)],1)],1)],1)],1),a("el-tab-pane",{attrs:{label:"加入项目",name:"second"}},[a("el-row",[a("el-col",{attrs:{span:8}},[a("el-input",{attrs:{placeholder:"请输入您要搜索的项目秘钥(请勿泄露)"},model:{value:e.search_number,callback:function(t){e.search_number=t},expression:"search_number"}},[a("el-button",{attrs:{slot:"append",icon:"el-icon-search"},on:{click:e.search},slot:"append"})],1)],1)],1),a("el-table",{staticStyle:{width:"100%"},attrs:{data:e.tableData,"header-cell-style":{"text-align":"center"},"cell-style":{"text-align":"center"}}},[a("el-table-column",{attrs:{type:"expand"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("el-row",[a("el-col",[a("el-form",{staticClass:"demo-table-expand",attrs:{"label-position":"left"}},[a("el-form-item",{attrs:{label:"项目成员"}},e._l(t.row.member,(function(t){return a("el-button",{key:t.index,attrs:{type:"text"}},[e._v("\n                                            "+e._s(t)+"\n                                        ")])})),1),a("el-form-item",{attrs:{label:"项目简述"}},[a("el-button",{attrs:{type:"text"}},[e._v(e._s(t.row.description))])],1),a("el-form-item",{attrs:{label:"项目申请时间"}},[a("el-button",{attrs:{type:"text"}},[e._v(e._s(t.row.time))])],1),a("el-form-item",{attrs:{label:"项目审核进度"}},[a("el-steps",{attrs:{active:1,simple:!1}},[a("el-step",{attrs:{title:"未审核",icon:"el-icon-close"}}),a("el-step",{attrs:{title:"正在审核",icon:"el-icon-loading"}}),a("el-step",{attrs:{title:"审核成功",icon:"el-icon-check"}})],1)],1)],1)],1)],1)]}}])}),a("el-table-column",{attrs:{prop:"name",label:"项目名称",width:"220"}}),a("el-table-column",{attrs:{prop:"realname",label:"项目负责人",width:"100"}}),a("el-table-column",{attrs:{prop:"college",label:"所属学院",width:"140"}}),a("el-table-column",{attrs:{prop:"role",label:"职称",width:"100"},scopedSlots:e._u([{key:"default",fn:function(t){return[1===t.row.teachers_title?a("el-button",{attrs:{type:"text"}},[e._v("助教")]):e._e(),2===t.row.teachers_title?a("el-button",{attrs:{type:"text"}},[e._v("讲师")]):e._e(),3===t.row.teachers_title?a("el-button",{attrs:{type:"text"}},[e._v("副教授")]):e._e(),4===t.row.teachers_title?a("el-button",{attrs:{type:"text"}},[e._v("教授")]):e._e()]}}])}),a("el-table-column",{attrs:{prop:"level",label:"项目类型",width:"180"},scopedSlots:e._u([{key:"default",fn:function(t){return[1===t.row.level?a("el-button",{attrs:{type:"text"}},[e._v("重点项目")]):e._e(),2===t.row.level?a("el-button",{attrs:{type:"text"}},[e._v("一般项目")]):e._e()]}}])}),a("el-table-column",{attrs:{prop:"type",label:"项目类别",width:"140"}}),a("el-table-column",{attrs:{prop:"phone",label:"联系电话",width:"180"}}),a("el-table-column",{attrs:{prop:"states",label:"审核状态",width:"100"},scopedSlots:e._u([{key:"default",fn:function(t){return[1===t.row.states?a("el-button",{attrs:{type:"text"}},[e._v("审核通过")]):e._e(),2===t.row.states?a("el-button",{attrs:{type:"text"}},[e._v("审核失败")]):e._e(),3===t.row.states?a("el-button",{attrs:{type:"text"}},[e._v("未审核")]):e._e()]}}])}),a("el-table-column",{attrs:{label:"操作",width:"80"},scopedSlots:e._u([{key:"default",fn:function(t){return[a("el-button",{attrs:{type:"text"},on:{click:function(a){return e.join(t.row.id)}}},[e._v("申请")])]}}])})],1)],1)],1)],1)},s=[],o=(a("ac6a"),a("6762"),a("7f7f"),{name:"ProjectApplication",data:function(){return{activeName:"first",count:0,form:{time:(new Date).toLocaleString(),name:"",file:[],thumb:[],keywords:"",description:"",type:"",level:"",realname:sessionStorage.getItem("realname"),project_number:"",search_number:this.$md5(Math.floor((new Date).getTime()/Math.floor(10*Math.random()+1))),username:sessionStorage.getItem("username"),member:[]},rules:{realname:[{required:!0,message:"请输入项目负责人",trigger:"blur"}],name:[{required:!0,message:"请输入项目名称",trigger:"blur"}],file:[{required:!0,message:"请上传项目所需文件",trigger:"blur"}],thumb:[{required:!0,message:"请选择项目有关图片",trigger:"blur"}],keywords:[{required:!0,message:"请输入项目关键词",trigger:"blur"}],description:[{required:!0,message:"请输入项目简述",trigger:"blur"}],type:[{required:!0,message:"请选择项目类别",trigger:"blur"}],level:[{required:!0,message:"请选择项目类型",trigger:"blur"}]},uploadFile:this.$api.UPLOADFILE,upload:this.$api.UPLOAD,options:[{value:1,label:"重点项目"},{value:2,label:"一般项目"}],options1:[],value:"",tableData:[],search_number:"",oldmember:[],flag:!0,flag1:!0,research_project:[],research_project1:[],id:"",name:""}},methods:{handleFileSuccess:function(e,t){if("error"===e)this.$message.error("上传失败");else{var a=t.name.lastIndexOf("."),r={};r.name=t.name.slice(0,a),r.url=e,this.form.file.push(r)}},handleAvatarSuccess1:function(e,t){if("error"===e)this.$message.error("上传失败");else{var a=t.name.lastIndexOf("."),r={};r.name=t.name.slice(0,a),r.url=e,this.form.thumb.push(r)}},beforePhoneUpload:function(e){var t=["image/jpeg","image/jpg","image/png"],a=e.size/1024/1024<2;return t.includes(e.type)?a?void 0:(this.$message.error("上传头像图片大小不能超过 2MB!"),!1):(this.$message.error("上传的图片格式有误，请重新上传！"),!1)},beforeFileUpload:function(e){var t=["application/msword","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","application/zip"],a=e.size/1024/1024<5;return t.includes(e.type)?a?void 0:(this.$message.error("上传文件大小不能超过 5MB!"),!1):(this.$message.error("上传的文件格式有误，请重新上传！"),!1)},handleRemove:function(e){for(var t=0;t<this.form.thumb.length;t++)e.name===this.form.thumb[t].name&&this.form.thumb.splice(t,t+1)},handleRemove1:function(e){for(var t=0;t<this.form.file.length;t++)e.name===this.form.file[t].name&&this.form.file.splice(t,t+1)},apply:function(){var e=this;this.$confirm("是否确定申请该项目？","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then((function(){e.$refs.applyForm.validate((function(t){if(t){var a=(new Date).getFullYear(),r=(new Date).getMonth(),s=(new Date).getDate();r<10?(r+=1,e.form.project_number="NU"+a+"0"+r+s+e.form.type+e.form.level+e.count+"ER"):(r+=1,e.form.project_number="NU"+a+r+s+e.form.type+e.form.level+e.count+"ER"),console.log(e.form.project_number),e.form.file=JSON.stringify(e.form.file),e.form.thumb=JSON.stringify(e.form.thumb);var o={};o.username=sessionStorage.getItem("username"),o.realname=sessionStorage.getItem("realname"),e.form.member.push(o),e.form.member=JSON.stringify(e.form.member),e.$axios.post(e.$api.PROJECT,e.form).then((function(t){200===t.data.code?(e.open(),e.updateResearchProject(t.data.data),e.$message.success(t.data.msg),e.$refs.applyForm.resetFields()):(e.$message.error(t.data.msg),e.$refs.applyForm.resetFields())}))}else e.$message.error("请检查内容是否输入正确！")}))})).catch((function(){e.$message({type:"info",message:"已取消申请"})}))},getProjectType:function(){var e=this;this.$axios.get(this.$api.PROJECT_TYPE).then((function(t){200===t.data.code?(e.options1=t.data.data,e.count=t.data.count+1):e.$message.error("获取失败")}))},open:function(){this.$notify({title:"请务必记住搜索秘钥，关闭以后将不再提示，如不慎丢失，请联系管理员。",message:"搜索秘钥:"+this.form.search_number,duration:0,type:"success"})},search:function(){var e=this;this.search_number?this.$axios.put(this.$api.PROJECT,{search_number:this.search_number,username:sessionStorage.getItem("username")}).then((function(t){if(200===t.data.code){var a=[];if(t.data.data[0].member){var r=JSON.parse(t.data.data[0].member);r.forEach((function(e,t){a.push(++t+". "+e.realname+" ")}))}t.data.data[0].member=a,e.tableData=t.data.data,e.id=t.data.data[0].id,e.name=t.data.data[0].name,e.$message.success(t.data.msg),e.oldmember=JSON.parse(t.data.member),e.research_project1=JSON.parse(t.data.research_project)}else e.tableData=[],e.$message.error(t.data.msg)})):this.$message.error("请正确输入搜索秘钥！")},join:function(e){var t=this;this.$confirm("是否确认加入该项目","提示",{confirmButtonText:"确定",cancelButtonText:"取消",type:"warning"}).then((function(){t.$axios.get(t.$api.PROJECT,{id:e,yzsq:"验证申请"}).then((function(a){if(200===a.data.code){var r={};r.username=sessionStorage.getItem("username"),r.realname=sessionStorage.getItem("realname");for(var s=0;s<t.oldmember.length;s++)r.realname===t.oldmember[s].realname&&(t.flag=!1);!0===t.flag&&t.oldmember.push(r);var o={};o.id=t.id,o.name=t.name;for(var l=0;l<t.research_project1.length;l++)o.id===t.research_project1[l].id&&(t.flag1=!1);!0===t.flag&&t.research_project1.push(o),t.oldmember.length<=5&&t.research_project1.length<=2?(t.oldmember=JSON.stringify(t.oldmember),t.research_project1=JSON.stringify(t.research_project1),t.$axios.put(t.$api.PROJECT,{member:t.oldmember,id:e,username:sessionStorage.getItem("username")}).then((function(e){200===e.data.code?(t.$message.success(e.data.msg),t.updateResearchProject1(t.research_project1)):t.$message.error(e.data.msg)}))):(t.oldmember.length>5&&t.$message.error("对不起，此科研小组成员已满，请重新申请！"),t.research_project1.length>2&&t.$message.error("对不起，每人至多只能参与两个项目！"))}else t.$message.error(a.data.msg)}))})).catch((function(){t.$message({type:"info",message:"已取消申请"})}))},updateResearchProject:function(e){var t=this;console.log(e);var a={};a.id=e.id,a.name=e.name,this.research_project.push(a),this.$axios.put(this.$api.UPDATERESEARCHPROJECT,{research_project:JSON.stringify(this.research_project),username:sessionStorage.getItem("username")}).then((function(e){200===e.data.code?t.$message.success("参研项目更新成功"):t.$message.error("参研项目更新失败")}))},updateResearchProject1:function(e){var t=this;this.$axios.put(this.$api.UPDATERESEARCHPROJECT,{research_project:e,username:sessionStorage.getItem("username")}).then((function(e){200===e.data.code?t.$message.success("参研项目更新成功"):t.$message.error("参研项目更新失败")}))}},mounted:function(){this.getProjectType()}}),l=o,n=(a("c80a"),a("2877")),i=Object(n["a"])(l,r,s,!1,null,"45731d15",null);t["default"]=i.exports},"8f44":function(e,t,a){},c80a:function(e,t,a){"use strict";var r=a("8f44"),s=a.n(r);s.a}}]);
//# sourceMappingURL=chunk-72941a5d.ff285f59.js.map