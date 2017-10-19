</div>
</div>
<div id="container-bottom"></div>
<!--FOOTER-->
<div id="footer" class="footer">
	<div id="links">
		<?php if ($this->uri->segment('1') != 'logon'): ?>
			<div>
				<a href="/">Home</a> |
				<a href="/findcustomers">Find New Customers</a> |
				<a href="/increaseservices">Increase Services</a> |
				<a href="/increaseservices">LiteracyDecision</a> |
				<a href="/compareservices">Compare Service Areas</a> |
				<a href="/marketresearch">Market Research</a> |
				<?php if ($this->session->userdata('uid') > 0): ?>
					<a href="/reports">Reports</a> |
				<?php endif; ?>
				<a href="support">Support</a>
			</div>
		<?php endif; ?>
		<div id="copyright" class="copyright">&copy; Copyright 2010 CIVICTechnologies. All Rights Reserved.</div>
	</div>
</div><!--End DIV footer-->
</div>
</div>
</body>
</html>
