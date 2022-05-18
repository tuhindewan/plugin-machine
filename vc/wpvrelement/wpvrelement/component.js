import React from 'react'
import {getService} from 'vc-cake'
import apiFetch from '@wordpress/api-fetch';
const vcvAPI = getService('api')

export default class WpvrElement extends vcvAPI.elementComponent {

  render() {
    const {id, atts, editor} = this.props
    const {wpvr_id, wpvr_height, wpvr_width, wpvr_radius} = atts // destructuring assignment for attributes from settings.json with access public

    const vrshortcode = '[wpvr id="' + wpvr_id + '" width="' + wpvr_width + '" height="' + wpvr_height + '" radius="'+wpvr_radius+'"]'

    return <div>
      <div>
        {vrshortcode}
      </div>
    </div>
  }
}
