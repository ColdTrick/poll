<?php

// set correct class handler for poll
if (get_subtype_id('object', Poll::SUBTYPE)) {
	update_subtype('object', Poll::SUBTYPE, 'Poll');
} else {
	add_subtype('object', Poll::SUBTYPE, 'Poll');
}
