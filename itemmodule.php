<?php
$itemstr=<<<ITEMSTR
		<div class="detail">
            <div class="post">
                <div class="content">
                    <h1 class="title"><a href='@pagelink'>@pagetitle</a></h1>
					<div class="info">
						<span class="date"><i class="glyphicon glyphicon-calendar"></i>
							@datetime
						</span>
						<span class="tags"><i class="glyphicon glyphicon-tags"></i>
							@tags
						</span>
					</div>
					<div class="post_body">
						@description
					</div>
				</div>
			</div>
		</div>
ITEMSTR;
?>