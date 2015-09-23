<?php

// set class handler to default Elgg handling
if (get_subtype_id('object', Poll::SUBTYPE)) {
	update_subtype('object', Poll::SUBTYPE);
}
