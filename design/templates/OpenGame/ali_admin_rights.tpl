<br />
<table width=519>
  <tr><td class=c colspan=7>
    <span class="fl">{L_ali_adm_rights_title}</span>
    <span class="fr"><a href="alliance.php?mode=admin">{L_ali_adm_return}</a></span>
  </td></tr>

  <form action="alliance.php?mode=admin&edit=rights" method=POST>
    <tr>
      <td class="c"><img src="design/images/abort.gif" alt="{L_ali_adm_rights_rank_delete}" title="{L_ali_adm_rights_rank_delete}" border="0"></td>
      <td class="c">{L_ali_adm_rights_rank_name}</td>
      <td class="c"><img src="design/images/r8.png" alt="{L_ali_adm_rights_mass_mail}" title="{L_ali_adm_rights_mass_mail}"></td>
      <td class="c"><img src="design/images/r7.png" alt="{L_ali_adm_rights_view_online}" title="{L_ali_adm_rights_view_online}"></td>
      <td class="c"><img src="design/images/r5.png" alt="{L_ali_req_check}" title="{L_ali_req_check}"></td>
      <td class="c"><img src="design/images/r2.png" alt="{L_ali_adm_kick}" title="{L_ali_adm_kick}"></td>
      <td class="c"><img src="design/images/r9.png" alt="{L_ali_adm_rights_helper}" title="{L_ali_adm_rights_helper}"></td>
    </tr>

    <!-- BEGIN rank -->
      <tr>
        <th>
          <!-- IF .rank > 1 -->
            <a href="alliance.php?mode=admin&edit=rights&d={rank.ID}"><img src="design/images/abort.gif" alt="{L_ali_adm_rights_rank_delete}" title="{L_ali_adm_rights_rank_delete}" border="0"></a>
          <!-- ELSE -->
            &nbsp;
          <!-- ENDIF -->
        </th>
        <th><input type=text name="u[{rank.ID}][name]" value="{rank.NAME}" size="60" maxlength="60"></th>
        <th><input type=checkbox name="u[{rank.ID}][{rank.N1}]"{rank.R1} value="1"></th>
        <th><input type=checkbox name="u[{rank.ID}][{rank.N2}]"{rank.R2} value="1"></th>
        <th><input type=checkbox name="u[{rank.ID}][{rank.N3}]"{rank.R3} value="1"></th>
        <th><input type=checkbox name="u[{rank.ID}][{rank.N4}]"{rank.R4} value="1"></th>
        <th><input type=checkbox name="u[{rank.ID}][{rank.N5}]"{rank.R5} value="1"></th>
      </tr>
    <!-- BEGINELSE rank -->
      <th colspan=8>{L_ali_adm_rights_rank_none}</th>      
    <!-- END rank -->

    <tr><th colspan=7><input type=submit value="{L_sys_save}"></th></tr>
  </form>

  <form action="alliance.php?mode=admin&edit=rights&add=name" method=POST>
    <tr>
      <th>&nbsp;</th>
      <th><input type=text name="newRankName" size="60" maxlength="60" value="{L_ali_adm_rights_rank_new}"></th>
      <th colspan="5"><input type=submit value="{L_sys_create}"></th>
    </tr>
  </form>
</table>

<br />

<form action="alliance.php?mode=admin&edit=rights" method=POST>
<table width=519>
	<tr><td class=c colspan=2>{L_ali_adm_rights_legend}</td></tr>
	<tr><th><img src="design/images/r8.png"></th><th class="c left">{L_ali_adm_rights_mass_mail}</th></tr>
	<tr><th><img src="design/images/r7.png"></th><th class="c left">{L_ali_adm_rights_view_online}</th></tr>
	<tr><th><img src="design/images/r5.png"></th><th class="c left">{L_ali_req_check}</th></tr>
	<tr><th><img src="design/images/r2.png"></th><th class="c left">{L_ali_adm_kick}</th></tr>
	<tr><th><img src="design/images/r9.png"></th><th class="c left">{L_ali_adm_rights_helper}</th></tr>
	<tr><td class="c right" colspan="2"><a href="alliance.php">{L_ali_sys_main_page}</a></td></tr>
</table>
</form>
	